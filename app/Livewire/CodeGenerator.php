<?php

namespace App\Livewire;

use Livewire\Component;

class CodeGenerator extends Component
{
    public $stackType = 'tall'; // tall or blade
    public $modelName = '';
    public $fields = [];
    public $relationships = [];
    public $generateMigration = true;
    
    protected $listeners = ['filesGenerated'];
    public $generateModel = true;
    // TALL Stack options
    public $tallOption = 'livewire'; // livewire, filament, both
    public $generateLivewireComponent = false;
    public $generateFilamentResource = false;
    
    // Laravel Blade options
    public $generateController = false;
    public $generateViews = false;
    public $generateRequest = false;
    
    // Common options
    public $generateRoutes = true;
    public $generateApiRoutes = false;
    public $generateApiController = false;
    public $generateFactory = false;
    public $generateSeeder = false;
    public $generatedFiles = [];
    public $showPreview = false;
    public $activeTab = 'migration';

    public function mount()
    {
        $this->addField();
    }

    public function addField()
    {
        $this->fields[] = [
            'name' => '',
            'type' => 'string',
            'nullable' => false,
            'unique' => false,
        ];
    }

    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
    }

    public function addRelationship()
    {
        $this->relationships[] = [
            'name' => '',
            'type' => 'belongsTo',
            'model' => '',
        ];
    }

    public function removeRelationship($index)
    {
        unset($this->relationships[$index]);
        $this->relationships = array_values($this->relationships);
    }

    public function generate()
    {
        // تحديد عدد الحقول المسموح
        if (count($this->fields) > 50) {
            session()->flash('error', 'Maximum 50 fields allowed');
            return;
        }
        
        if (count($this->relationships) > 20) {
            session()->flash('error', 'Maximum 20 relationships allowed');
            return;
        }
        
        // تنظيف وتنسيق اسم الموديل تلقائياً
        $this->modelName = preg_replace('/[^a-zA-Z_]/', '', $this->modelName);
        $this->modelName = str_replace('_', '', $this->modelName);
        $this->modelName = ucfirst($this->modelName);
        
        // تنظيف وتنسيق أسماء الحقول تلقائياً
        foreach ($this->fields as $key => $field) {
            $this->fields[$key]['name'] = preg_replace('/[^a-zA-Z0-9_]/', '', $field['name']);
            $this->fields[$key]['name'] = strtolower($this->fields[$key]['name']);
        }
        
        // تنظيف أسماء العلاقات
        foreach ($this->relationships as $key => $rel) {
            if (!empty($rel['name'])) {
                $this->relationships[$key]['name'] = preg_replace('/[^a-zA-Z0-9_]/', '', $rel['name']);
                $this->relationships[$key]['name'] = strtolower($this->relationships[$key]['name']);
            }
            if (!empty($rel['model'])) {
                $this->relationships[$key]['model'] = preg_replace('/[^a-zA-Z_]/', '', $rel['model']);
                $this->relationships[$key]['model'] = str_replace('_', '', $this->relationships[$key]['model']);
                $this->relationships[$key]['model'] = ucfirst($this->relationships[$key]['model']);
            }
        }
        
        $this->validate([
            'modelName' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[A-Z][a-zA-Z0-9]*$/'],
            'fields.*.name' => ['required', 'string', 'min:1', 'max:50', 'regex:/^[a-z_][a-z0-9_]*$/'],
            'fields.*.type' => ['required', 'string', 'in:string,text,longText,char,integer,tinyInteger,bigInteger,unsignedBigInteger,boolean,date,datetime,timestamp,time,year,decimal,float,double,json,enum'],
            'relationships.*.name' => ['nullable', 'string', 'regex:/^[a-z_][a-z0-9_]*$/'],
            'relationships.*.type' => ['nullable', 'string', 'in:belongsTo,hasOne,hasMany,belongsToMany,morphTo,morphOne,morphMany,morphToMany,hasManyThrough'],
            'relationships.*.model' => ['nullable', 'string', 'regex:/^[A-Z][a-zA-Z0-9]*$/'],
        ]);

        $this->generatedFiles = [];

        if ($this->generateMigration) {
            $this->generatedFiles['migration'] = $this->generateMigrationCode();
        }
        if ($this->generateModel) {
            $this->generatedFiles['model'] = $this->generateModelCode();
        }
        
        // TALL Stack files
        if ($this->stackType === 'tall') {
            if ($this->generateLivewireComponent) {
                $this->generatedFiles['livewire_component'] = $this->generateLivewireComponentCode();
                $this->generatedFiles['livewire_view'] = $this->generateLivewireViewCode();
            }
            if ($this->generateFilamentResource) {
                $this->generatedFiles['filament_resource'] = $this->generateFilamentResourceCode();
                $this->generatedFiles['filament_list_page'] = $this->generateFilamentListPageCode();
                $this->generatedFiles['filament_create_page'] = $this->generateFilamentCreatePageCode();
                $this->generatedFiles['filament_edit_page'] = $this->generateFilamentEditPageCode();
            }
        }
        
        // Laravel Blade files
        if ($this->stackType === 'blade') {
            if ($this->generateController) {
                $this->generatedFiles['controller'] = $this->generateControllerCode();
            }
            if ($this->generateViews) {
                $this->generatedFiles['index_view'] = $this->generateBladeIndexViewCode();
                $this->generatedFiles['create_view'] = $this->generateBladeCreateViewCode();
                $this->generatedFiles['edit_view'] = $this->generateBladeEditViewCode();
            }
            if ($this->generateRequest) {
                $this->generatedFiles['form_request'] = $this->generateFormRequestCode();
            }
        }
        
        if ($this->generateRoutes) {
            $this->generatedFiles['routes'] = $this->generateRoutesCode();
        }
        if ($this->generateApiRoutes) {
            $this->generatedFiles['api_routes'] = $this->generateApiRoutesCode();
        }
        if ($this->generateApiController) {
            $this->generatedFiles['api_controller'] = $this->generateApiControllerCode();
        }
        if ($this->generateFactory) {
            $this->generatedFiles['factory'] = $this->generateFactoryCode();
        }
        if ($this->generateSeeder) {
            $this->generatedFiles['seeder'] = $this->generateSeederCode();
        }

        $this->showPreview = true;
        $this->activeTab = array_key_first($this->generatedFiles);
        $this->dispatch('filesGenerated');
    }

    private function generateMigrationCode()
    {
        $tableName = \Illuminate\Support\Str::snake(\Illuminate\Support\Str::plural($this->modelName));
        $fields = '';
        $indexes = '';
        
        foreach ($this->fields as $field) {
            $fieldName = preg_replace('/[^a-z0-9_]/', '', $field['name']);
            $fieldType = in_array($field['type'], ['string','text','longText','char','integer','tinyInteger','bigInteger','unsignedBigInteger','boolean','date','datetime','timestamp','time','year','decimal','float','double','json','enum']) ? $field['type'] : 'string';
            
            $line = "            \$table->{$fieldType}('{$fieldName}')";
            if ($field['nullable']) $line .= "->nullable()";
            if ($field['unique']) $line .= "->unique()";
            $line .= ";\n";
            $fields .= $line;
            
            // إضافة index للحقول المهمة فقط
            if (str_ends_with($fieldName, '_id')) {
                $indexes .= "            \$table->index('{$fieldName}');\n";
            }
        }

        return "<?php\n\nuse Illuminate\\Database\\Migrations\\Migration;\nuse Illuminate\\Database\\Schema\\Blueprint;\nuse Illuminate\\Support\\Facades\\Schema;\n\nreturn new class extends Migration\n{\n    public function up(): void\n    {\n        Schema::create('{$tableName}', function (Blueprint \$table) {\n            \$table->id();\n{$fields}            \$table->timestamps();\n{$indexes}        });\n    }\n\n    public function down(): void\n    {\n        Schema::dropIfExists('{$tableName}');\n    }\n};";
    }

    private function generateModelCode()
    {
        $fillable = collect($this->fields)
            ->pluck('name')
            ->map(fn($f) => "'" . preg_replace('/[^a-z0-9_]/', '', $f) . "'")
            ->join(", ");
            
        $casts = collect($this->fields)->map(function($f) {
            return match($f['type']) {
                'boolean' => "        '{$f['name']}' => 'boolean',",
                'integer', 'bigInteger' => "        '{$f['name']}' => 'integer',",
                'decimal', 'float' => "        '{$f['name']}' => 'decimal:2',",
                'date' => "        '{$f['name']}' => 'date',",
                'datetime', 'timestamp' => "        '{$f['name']}' => 'datetime',",
                'json' => "        '{$f['name']}' => 'array',",
                default => null
            };
        })->filter()->join("\n");
        
        $castsBlock = $casts ? "\n\n    protected \$casts = [\n{$casts}\n    ];" : '';
        
        $relations = '';
        foreach ($this->relationships as $rel) {
            if (empty($rel['name']) || empty($rel['model'])) continue;
            $relName = preg_replace('/[^a-z0-9_]/', '', $rel['name']);
            $relModel = preg_replace('/[^A-Za-z0-9]/', '', $rel['model']);
            $relType = in_array($rel['type'], ['belongsTo','hasOne','hasMany','belongsToMany','morphTo','morphOne','morphMany','morphToMany','hasManyThrough']) ? $rel['type'] : 'belongsTo';
            $relations .= "\n    public function {$relName}()\n    {\n        return \$this->{$relType}({$relModel}::class);\n    }\n";
        }

        return "<?php\n\nnamespace App\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Factories\\HasFactory;\nuse Illuminate\\Database\\Eloquent\\Model;\n\nclass {$this->modelName} extends Model\n{\n    use HasFactory;\n\n    protected \$fillable = [{$fillable}];{$castsBlock}{$relations}\n}";
    }

    private function generateLivewireComponentCode()
    {
        $modelVar = \Illuminate\Support\Str::camel($this->modelName);
        $modelPlural = \Illuminate\Support\Str::plural($modelVar);
        
        $formFields = collect($this->fields)->map(fn($f) => "    public \${$f['name']} = '';")->join("\n");
        $rules = collect($this->fields)->map(function($f) {
            $rule = $f['nullable'] ? 'nullable' : 'required';
            $type = match($f['type']) {
                'integer', 'bigInteger' => $rule . '|integer',
                'boolean' => $rule . '|boolean',
                'date' => $rule . '|date',
                'json' => $rule . '|array',
                default => $rule
            };
            return "            '{$f['name']}' => '{$type}',";
        })->join("\n");
        $fillData = collect($this->fields)->map(fn($f) => "            '{$f['name']}' => \$this->{$f['name']},")->join("\n");

        return "<?php\n\nnamespace App\\Livewire\\{$this->modelName};\n\nuse App\\Models\\{$this->modelName};\nuse Livewire\\Attributes\\Title;\nuse Livewire\\Component;\nuse Livewire\\WithPagination;\n\n#[Title('Manage {$this->modelName}')]\nclass Manage{$this->modelName} extends Component\n{\n    use WithPagination;\n\n{$formFields}\n    public \${$modelVar}Id = null;\n    public \$showForm = false;\n\n    protected function rules()\n    {\n        return [\n{$rules}\n        ];\n    }\n\n    public function create()\n    {\n        \$this->resetForm();\n        \$this->showForm = true;\n    }\n\n    public function edit(\${$modelVar}Id)\n    {\n        \$this->{$modelVar}Id = \${$modelVar}Id;\n        \${$modelVar} = {$this->modelName}::findOrFail(\${$modelVar}Id);\n        \n" . collect($this->fields)->map(fn($f) => "        \$this->{$f['name']} = \${$modelVar}->{$f['name']};")->join("\n") . "\n        \$this->showForm = true;\n    }\n\n    public function save()\n    {\n        \$this->validate();\n\n        {$this->modelName}::updateOrCreate(\n            ['id' => \$this->{$modelVar}Id],\n            [\n{$fillData}\n            ]\n        );\n\n        \$this->resetForm();\n        session()->flash('success', '{$this->modelName} saved successfully!');\n    }\n\n    public function delete(\${$modelVar}Id)\n    {\n        {$this->modelName}::findOrFail(\${$modelVar}Id)->delete();\n        session()->flash('success', '{$this->modelName} deleted successfully!');\n    }\n\n    public function resetForm()\n    {\n" . collect($this->fields)->map(fn($f) => "        \$this->{$f['name']} = '';")->join("\n") . "\n        \$this->{$modelVar}Id = null;\n        \$this->showForm = false;\n    }\n\n    public function render()\n    {\n        return view('livewire.{$modelVar}.manage-{$modelVar}', [\n            '{$modelPlural}' => {$this->modelName}::latest()->paginate(10)\n        ]);\n    }\n}";
    }

    private function generateFilamentResourceCode()
    {
        $formFields = collect($this->fields)->map(fn($f) => "                Forms\\Components\\TextInput::make('{$f['name']}')" . ($f['nullable'] ? "" : "\n                    ->required()") . ",")->join("\n");
        $tableColumns = collect($this->fields)->map(fn($f) => "                Tables\\Columns\\TextColumn::make('{$f['name']}')\n                    ->searchable()\n                    ->sortable(),")->join("\n");

        return "<?php\n\nnamespace App\\Filament\\Resources;\n\nuse App\\Filament\\Resources\\{$this->modelName}Resource\\Pages;\nuse App\\Models\\{$this->modelName};\nuse Filament\\Forms;\nuse Filament\\Forms\\Form;\nuse Filament\\Resources\\Resource;\nuse Filament\\Tables;\nuse Filament\\Tables\\Table;\n\nclass {$this->modelName}Resource extends Resource\n{\n    protected static ?string \$model = {$this->modelName}::class;\n\n    protected static ?string \$navigationIcon = 'heroicon-o-rectangle-stack';\n\n    public static function form(Form \$form): Form\n    {\n        return \$form\n            ->schema([\n{$formFields}\n            ]);\n    }\n\n    public static function table(Table \$table): Table\n    {\n        return \$table\n            ->columns([\n{$tableColumns}\n            ])\n            ->filters([])\n            ->actions([\n                Tables\\Actions\\EditAction::make(),\n                Tables\\Actions\\DeleteAction::make(),\n            ])\n            ->bulkActions([\n                Tables\\Actions\\BulkActionGroup::make([\n                    Tables\\Actions\\DeleteBulkAction::make(),\n                ]),\n            ]);\n    }\n\n    public static function getPages(): array\n    {\n        return [\n            'index' => Pages\\List{$this->modelName}s::route('/'),\n            'create' => Pages\\Create{$this->modelName}::route('/create'),\n            'edit' => Pages\\Edit{$this->modelName}::route('/{record}/edit'),\n        ];\n    }\n}";
    }

    private function generateRoutesCode()
    {
        $modelVar = \Illuminate\Support\Str::camel($this->modelName);
        $modelKebab = \Illuminate\Support\Str::kebab($this->modelName);
        $modelPlural = \Illuminate\Support\Str::plural($modelKebab);
        
        if ($this->stackType === 'tall') {
            return "<?php\n\n// Add this to routes/web.php\n\nuse App\\Livewire\\{$this->modelName}\\Manage{$this->modelName};\n\nRoute::get('/{$modelPlural}', Manage{$this->modelName}::class)->name('{$modelVar}.index');";
        }
        
        // Laravel Blade routes
        return "<?php\n\n// Add this to routes/web.php\n\nuse App\\Http\\Controllers\\{$this->modelName}Controller;\n\nRoute::resource('{$modelPlural}', {$this->modelName}Controller::class);";
    }

    private function generateFilamentListPageCode()
    {
        return "<?php\n\nnamespace App\\Filament\\Resources\\{$this->modelName}Resource\\Pages;\n\nuse App\\Filament\\Resources\\{$this->modelName}Resource;\nuse Filament\\Actions;\nuse Filament\\Resources\\Pages\\ListRecords;\n\nclass List{$this->modelName}s extends ListRecords\n{\n    protected static string \$resource = {$this->modelName}Resource::class;\n\n    protected function getHeaderActions(): array\n    {\n        return [\n            Actions\\CreateAction::make(),\n        ];\n    }\n}";
    }

    private function generateFilamentCreatePageCode()
    {
        return "<?php\n\nnamespace App\\Filament\\Resources\\{$this->modelName}Resource\\Pages;\n\nuse App\\Filament\\Resources\\{$this->modelName}Resource;\nuse Filament\\Resources\\Pages\\CreateRecord;\n\nclass Create{$this->modelName} extends CreateRecord\n{\n    protected static string \$resource = {$this->modelName}Resource::class;\n}";
    }

    private function generateFilamentEditPageCode()
    {
        return "<?php\n\nnamespace App\\Filament\\Resources\\{$this->modelName}Resource\\Pages;\n\nuse App\\Filament\\Resources\\{$this->modelName}Resource;\nuse Filament\\Actions;\nuse Filament\\Resources\\Pages\\EditRecord;\n\nclass Edit{$this->modelName} extends EditRecord\n{\n    protected static string \$resource = {$this->modelName}Resource::class;\n\n    protected function getHeaderActions(): array\n    {\n        return [\n            Actions\\DeleteAction::make(),\n        ];\n    }\n}";
    }

    private function generateApiRoutesCode()
    {
        $modelVar = \Illuminate\Support\Str::camel($this->modelName);
        $modelKebab = \Illuminate\Support\Str::kebab(\Illuminate\Support\Str::plural($this->modelName));
        
        return "<?php\n\n// Add this to routes/api.php\n\nuse App\\Http\\Controllers\\Api\\{$this->modelName}Controller;\n\nRoute::apiResource('{$modelKebab}', {$this->modelName}Controller::class);";
    }

    private function generateApiControllerCode()
    {
        $modelVar = \Illuminate\Support\Str::camel($this->modelName);
        $fillable = collect($this->fields)->pluck('name')->map(fn($f) => "'{$f}'")->join(", ");
        $validationRules = collect($this->fields)->map(function($f) {
            $rule = $f['nullable'] ? 'nullable' : 'required';
            return "            '{$f['name']}' => '{$rule}',";
        })->join("\n");

        return "<?php\n\nnamespace App\\Http\\Controllers\\Api;\n\nuse App\\Http\\Controllers\\Controller;\nuse App\\Models\\{$this->modelName};\nuse Illuminate\\Http\\Request;\n\nclass {$this->modelName}Controller extends Controller\n{\n    public function index()\n    {\n        return {$this->modelName}::all();\n    }\n\n    public function store(Request \$request)\n    {\n        \$validated = \$request->validate([\n{$validationRules}\n        ]);\n\n        \${$modelVar} = {$this->modelName}::create(\$validated);\n\n        return response()->json(\${$modelVar}, 201);\n    }\n\n    public function show({$this->modelName} \${$modelVar})\n    {\n        return \${$modelVar};\n    }\n\n    public function update(Request \$request, {$this->modelName} \${$modelVar})\n    {\n        \$validated = \$request->validate([\n{$validationRules}\n        ]);\n\n        \${$modelVar}->update(\$validated);\n\n        return response()->json(\${$modelVar});\n    }\n\n    public function destroy({$this->modelName} \${$modelVar})\n    {\n        \${$modelVar}->delete();\n\n        return response()->json(null, 204);\n    }\n}";
    }

    private function generateFactoryCode()
    {
        $factoryFields = collect($this->fields)->map(function($f) {
            if (str_ends_with($f['name'], '_id')) {
                $modelName = \Illuminate\Support\Str::studly(str_replace('_id', '', $f['name']));
                return "            '{$f['name']}' => {$modelName}::factory(),";
            }
            $faker = match($f['type']) {
                'string' => str_contains($f['name'], 'email') ? "fake()->unique()->safeEmail()" : (str_contains($f['name'], 'name') ? "fake()->name()" : "fake()->word()"),
                'text' => "fake()->paragraph()",
                'integer', 'bigInteger' => "fake()->numberBetween(1, 100)",
                'boolean' => "fake()->boolean()",
                'date' => "fake()->date()",
                'datetime', 'timestamp' => "fake()->dateTime()",
                'decimal', 'float' => "fake()->randomFloat(2, 0, 1000)",
                'json' => "['key' => fake()->word()]",
                default => "fake()->word()"
            };
            return "            '{$f['name']}' => {$faker},";
        })->join("\n");

        return "<?php\n\nnamespace Database\\Factories;\n\nuse App\\Models\\{$this->modelName};\nuse Illuminate\\Database\\Eloquent\\Factories\\Factory;\n\nclass {$this->modelName}Factory extends Factory\n{\n    protected \$model = {$this->modelName}::class;\n\n    public function definition(): array\n    {\n        return [\n{$factoryFields}\n        ];\n    }\n}";
    }

    private function generateSeederCode()
    {
        return "<?php\n\nnamespace Database\\Seeders;\n\nuse App\\Models\\{$this->modelName};\nuse Illuminate\\Database\\Seeder;\n\nclass {$this->modelName}Seeder extends Seeder\n{\n    public function run(): void\n    {\n        {$this->modelName}::factory()->count(10)->create();\n    }\n}";
    }
    
    private function generateControllerCode()
    {
        $modelVar = \Illuminate\Support\Str::camel($this->modelName);
        $modelPlural = \Illuminate\Support\Str::plural($modelVar);
        
        return "<?php\n\nnamespace App\\Http\\Controllers;\n\nuse App\\Models\\{$this->modelName};\nuse App\\Http\\Requests\\{$this->modelName}Request;\n\nclass {$this->modelName}Controller extends Controller\n{\n    public function index()\n    {\n        \${$modelPlural} = {$this->modelName}::latest()->paginate(15);\n        return view('{$modelVar}.index', compact('{$modelPlural}'));\n    }\n\n    public function create()\n    {\n        return view('{$modelVar}.create');\n    }\n\n    public function store({$this->modelName}Request \$request)\n    {\n        {$this->modelName}::create(\$request->validated());\n        return redirect()->route('{$modelVar}.index')->with('success', '{$this->modelName} created successfully');\n    }\n\n    public function edit({$this->modelName} \${$modelVar})\n    {\n        return view('{$modelVar}.edit', compact('{$modelVar}'));\n    }\n\n    public function update({$this->modelName}Request \$request, {$this->modelName} \${$modelVar})\n    {\n        \${$modelVar}->update(\$request->validated());\n        return redirect()->route('{$modelVar}.index')->with('success', '{$this->modelName} updated successfully');\n    }\n\n    public function destroy({$this->modelName} \${$modelVar})\n    {\n        \${$modelVar}->delete();\n        return redirect()->route('{$modelVar}.index')->with('success', '{$this->modelName} deleted successfully');\n    }\n}";
    }
    
    private function generateBladeIndexViewCode()
    {
        $modelVar = \Illuminate\Support\Str::camel($this->modelName);
        $modelPlural = \Illuminate\Support\Str::plural($modelVar);
        $tableHeaders = collect($this->fields)->map(fn($f) => "                <th>" . ucfirst($f['name']) . "</th>")->join("\n");
        $tableData = collect($this->fields)->map(fn($f) => "                    <td>{{ \${$modelVar}->{$f['name']} }}</td>")->join("\n");
        
        return "@extends('layouts.app')\n\n@section('content')\n<div class=\"container\">\n    <div class=\"d-flex justify-content-between align-items-center mb-3\">\n        <h1>{$this->modelName} List</h1>\n        <a href=\"{{ route('{$modelVar}.create') }}\" class=\"btn btn-primary\">Create New</a>\n    </div>\n\n    @if(session('success'))\n        <div class=\"alert alert-success\">{{ session('success') }}</div>\n    @endif\n\n    <table class=\"table\">\n        <thead>\n            <tr>\n{$tableHeaders}\n                <th>Actions</th>\n            </tr>\n        </thead>\n        <tbody>\n            @foreach(\${$modelPlural} as \${$modelVar})\n            <tr>\n{$tableData}\n                <td>\n                    <a href=\"{{ route('{$modelVar}.edit', \${$modelVar}) }}\" class=\"btn btn-sm btn-warning\">Edit</a>\n                    <form action=\"{{ route('{$modelVar}.destroy', \${$modelVar}) }}\" method=\"POST\" class=\"d-inline\">\n                        @csrf\n                        @method('DELETE')\n                        <button type=\"submit\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Are you sure?')\">Delete</button>\n                    </form>\n                </td>\n            </tr>\n            @endforeach\n        </tbody>\n    </table>\n\n    {{ \${$modelPlural}->links() }}\n</div>\n@endsection";
    }
    
    private function generateBladeCreateViewCode()
    {
        $modelVar = \Illuminate\Support\Str::camel($this->modelName);
        $formFields = collect($this->fields)->map(fn($f) => "        <div class=\"mb-3\">\n            <label class=\"form-label\">" . ucfirst($f['name']) . "</label>\n            <input type=\"text\" name=\"{$f['name']}\" class=\"form-control @error('{$f['name']}') is-invalid @enderror\" value=\"{{ old('{$f['name']}') }}\">\n            @error('{$f['name']}') <div class=\"invalid-feedback\">{{ \$message }}</div> @enderror\n        </div>")->join("\n\n");
        
        return "@extends('layouts.app')\n\n@section('content')\n<div class=\"container\">\n    <h1>Create {$this->modelName}</h1>\n\n    <form action=\"{{ route('{$modelVar}.store') }}\" method=\"POST\">\n        @csrf\n{$formFields}\n\n        <button type=\"submit\" class=\"btn btn-primary\">Create</button>\n        <a href=\"{{ route('{$modelVar}.index') }}\" class=\"btn btn-secondary\">Cancel</a>\n    </form>\n</div>\n@endsection";
    }
    
    private function generateBladeEditViewCode()
    {
        $modelVar = \Illuminate\Support\Str::camel($this->modelName);
        $formFields = collect($this->fields)->map(fn($f) => "        <div class=\"mb-3\">\n            <label class=\"form-label\">" . ucfirst($f['name']) . "</label>\n            <input type=\"text\" name=\"{$f['name']}\" class=\"form-control @error('{$f['name']}') is-invalid @enderror\" value=\"{{ old('{$f['name']}', \${$modelVar}->{$f['name']}) }}\">\n            @error('{$f['name']}') <div class=\"invalid-feedback\">{{ \$message }}</div> @enderror\n        </div>")->join("\n\n");
        
        return "@extends('layouts.app')\n\n@section('content')\n<div class=\"container\">\n    <h1>Edit {$this->modelName}</h1>\n\n    <form action=\"{{ route('{$modelVar}.update', \${$modelVar}) }}\" method=\"POST\">\n        @csrf\n        @method('PUT')\n{$formFields}\n\n        <button type=\"submit\" class=\"btn btn-primary\">Update</button>\n        <a href=\"{{ route('{$modelVar}.index') }}\" class=\"btn btn-secondary\">Cancel</a>\n    </form>\n</div>\n@endsection";
    }
    
    private function generateFormRequestCode()
    {
        $rules = collect($this->fields)->map(function($f) {
            $rule = $f['nullable'] ? 'nullable' : 'required';
            $type = match($f['type']) {
                'integer', 'bigInteger' => $rule . '|integer',
                'boolean' => $rule . '|boolean',
                'date' => $rule . '|date',
                'datetime', 'timestamp' => $rule . '|date',
                'decimal', 'float' => $rule . '|numeric',
                'json' => $rule . '|array',
                'text' => $rule . '|string|max:5000',
                default => $rule . '|string|max:255'
            };
            return "            '{$f['name']}' => '{$type}',";
        })->join("\n");
        
        return "<?php\n\nnamespace App\\Http\\Requests;\n\nuse Illuminate\\Foundation\\Http\\FormRequest;\n\nclass {$this->modelName}Request extends FormRequest\n{\n    public function authorize(): bool\n    {\n        return true;\n    }\n\n    public function rules(): array\n    {\n        return [\n{$rules}\n        ];\n    }\n}";
    }
    
    private function generateLivewireViewCode()
    {
        $modelVar = \Illuminate\Support\Str::camel($this->modelName);
        $modelPlural = \Illuminate\Support\Str::plural($modelVar);
        $tableHeaders = collect($this->fields)->map(fn($f) => "                <th class=\"px-4 py-2\">" . ucfirst($f['name']) . "</th>")->join("\n");
        $tableData = collect($this->fields)->map(fn($f) => "                    <td class=\"px-4 py-2\">{{ \${$modelVar}->{$f['name']} }}</td>")->join("\n");
        $formFields = collect($this->fields)->map(fn($f) => "        <div class=\"mb-4\">\n            <label class=\"block mb-2\">" . ucfirst($f['name']) . "</label>\n            <input type=\"text\" wire:model=\"{$f['name']}\" class=\"w-full px-3 py-2 border rounded\">\n            @error('{$f['name']}') <span class=\"text-red-500 text-sm\">{{ \$message }}</span> @enderror\n        </div>")->join("\n\n");
        
        return "<div>\n    <div class=\"flex justify-between mb-4\">\n        <h2 class=\"text-2xl font-bold\">{$this->modelName} Management</h2>\n        <button wire:click=\"create\" class=\"px-4 py-2 bg-blue-600 text-white rounded\">Create New</button>\n    </div>\n\n    @if(\$showForm)\n    <div class=\"bg-white p-6 rounded shadow mb-4\">\n        <h3 class=\"text-xl mb-4\">{{ \${$modelVar}Id ? 'Edit' : 'Create' }} {$this->modelName}</h3>\n        <form wire:submit.prevent=\"save\">\n{$formFields}\n            <div class=\"flex gap-2\">\n                <button type=\"submit\" class=\"px-4 py-2 bg-blue-600 text-white rounded\">Save</button>\n                <button type=\"button\" wire:click=\"resetForm\" class=\"px-4 py-2 bg-gray-300 rounded\">Cancel</button>\n            </div>\n        </form>\n    </div>\n    @endif\n\n    <table class=\"w-full bg-white rounded shadow\">\n        <thead>\n            <tr class=\"bg-gray-100\">\n{$tableHeaders}\n                <th class=\"px-4 py-2\">Actions</th>\n            </tr>\n        </thead>\n        <tbody>\n            @foreach(\${$modelPlural} as \${$modelVar})\n            <tr>\n{$tableData}\n                <td class=\"px-4 py-2\">\n                    <button wire:click=\"edit({{ \${$modelVar}->id }})\" class=\"text-blue-600\">Edit</button>\n                    <button wire:click=\"delete({{ \${$modelVar}->id }})\" class=\"text-red-600 ml-2\">Delete</button>\n                </td>\n            </tr>\n            @endforeach\n        </tbody>\n    </table>\n\n    <div class=\"mt-4\">{{ \${$modelPlural}->links() }}</div>\n</div>";
    }
    


    public function render()
    {
        return view('livewire.code-generator');
    }
}
