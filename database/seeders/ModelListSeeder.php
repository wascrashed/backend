<?php

namespace Database\Seeders;

use App\Tbuy\ModelInfo\Models\ModelField;
use App\Tbuy\ModelInfo\Models\ModelFieldReference;
use App\Tbuy\ModelInfo\Models\ModelList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModelListSeeder extends Seeder
{
    protected array $except = [
        'App\Tbuy\Auth\Models\User',
        ModelList::class,
        ModelField::class,
        ModelFieldReference::class
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modelsList = ModelList::query()->get();
        $modelPathList = glob(app_path('Tbuy/*/Models/*.php'));
        $preparedModelList = [];
        foreach ($modelPathList as $modelPath) {

            $model = $this->getModel($modelPath);
            if (in_array($model, $this->except) || $modelsList->where('model', '=', $model)->first()) {
                continue;
            }

            $label = class_basename($model);

            $preparedModelList[] = [
                'path' => $modelPath,
                'model' => $model,
                'label' => json_encode([
                    'en' => $label,
                    'ru' => $label,
                    'hy' => $label
                ])
            ];
        }

        ModelList::query()->insert($preparedModelList);
    }

    private function getModel(string $modelPath): string
    {
        return Str::of($modelPath)
            ->replace('/', '\\')
            ->after('app\Tbuy')
            ->beforeLast('.php')
            ->start('App\Tbuy')
            ->toString();
    }
}
