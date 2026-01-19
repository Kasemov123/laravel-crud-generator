<?php

namespace App\Filament\Resources\Components\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Schema;

class ComponentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->live(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/'),
                Textarea::make('description')
                    ->maxLength(1000)
                    ->default(null)
                    ->columnSpanFull(),
                
                Radio::make('input_method')
                    ->label('Choose Input Method')
                    ->options([
                        'upload' => 'Upload File',
                        'code' => 'Write Code',
                        'path' => 'File Path',
                    ])
                    ->default('upload')
                    ->live()
                    ->required()
                    ->columnSpanFull(),
                
                FileUpload::make('uploaded_file')
                    ->label('Upload Blade File')
                    ->acceptedFileTypes(['text/plain'])
                    ->maxSize(512)
                    ->maxFiles(1)
                    ->disk('public')
                    ->directory(function ($get) {
                        $categoryId = $get('category_id');
                        if ($categoryId) {
                            $category = \App\Models\Category::find($categoryId);
                            $dir = 'components/' . ($category ? preg_replace('/[^a-z0-9-]/', '', $category->slug) : 'uncategorized');
                            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($dir);
                            return $dir;
                        }
                        $dir = 'components/uncategorized';
                        \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($dir);
                        return $dir;
                    })
                    ->visibility('public')
                    ->helperText('Upload a .blade.php file (max 512KB)')
                    ->saveUploadedFileUsing(function ($file, $get) {
                        // فحص الامتداد الحقيقي
                        $extension = $file->getClientOriginalExtension();
                        if (!in_array($extension, ['php', 'blade'])) {
                            throw new \Exception('Only .blade.php files are allowed');
                        }
                        
                        $content = file_get_contents($file->getRealPath());
                        // منع PHP الخطير
                        $dangerousPatterns = ['<?php', '<?=', 'eval(', 'exec(', 'system(', 'shell_exec'];
                        foreach ($dangerousPatterns as $pattern) {
                            if (stripos($content, $pattern) !== false) {
                                throw new \Exception('Dangerous code detected in uploaded file');
                            }
                        }
                        
                        return $file;
                    })
                    ->visible(fn ($get) => $get('input_method') === 'upload')
                    ->required(fn ($get) => $get('input_method') === 'upload')
                    ->columnSpanFull(),
                
                CodeEditor::make('blade_code')
                    ->label('Blade Component Code')
                    ->helperText('Write your blade component code here')
                    ->visible(fn ($get) => $get('input_method') === 'code')
                    ->required(fn ($get) => $get('input_method') === 'code')
                    ->columnSpanFull(),
                
                TextInput::make('file_path')
                    ->label('File Path')
                    ->placeholder('components/category-name/component-name.blade.php')
                    ->helperText('Enter file path starting with "components/"')
                    ->maxLength(500)
                    ->rules([
                        'regex:/^components\/[a-z0-9-]+\/[a-z0-9-]+\.blade\.php$/',
                        function ($attribute, $value, $fail) {
                            if (str_contains($value, '..') || str_contains($value, '//')) {
                                $fail('Invalid file path format');
                            }
                        },
                    ])
                    ->visible(fn ($get) => $get('input_method') === 'path')
                    ->required(fn ($get) => $get('input_method') === 'path')
                    ->columnSpanFull(),
                
                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }
}
