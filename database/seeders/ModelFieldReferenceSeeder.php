<?php

namespace Database\Seeders;

use App\Tbuy\ModelInfo\Models\ModelFieldReference;
use App\Tbuy\ModelInfo\Models\ModelList;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionUnionType;

class ModelFieldReferenceSeeder extends Seeder
{
    protected array $relationClasses = [
        BelongsTo::class,
        BelongsToMany::class,
        HasMany::class,
        HasOne::class,
        MorphMany::class,
        MorphOne::class,
        MorphTo::class
    ];

    private string $relationColumnDoc = "@relationColumn";
    private string $morphRelationColumnDoc = "@relationMorphColumn";

    /**
     * Run the database seeds.
     * @throws ReflectionException
     * @throws \Exception
     */
    public function run(): void
    {
        ModelList::query()
            ->doesntHave('references')
            ->get()
            ->each(function (ModelList $model) {
                $modelObject = app($model->model);
                $reflection = new ReflectionClass($modelObject);
                $prepareColumns = [];
                foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {

                    if (
                        !in_array($method->getReturnType(), $this->relationClasses)
                        || $method->getFileName() !== $model->path
                    ) {
                        continue;
                    }

                    $column = $method->getDocComment()
                        ? $this->getRelationColumnFromDocComment($method->getDocComment())
                        : $this->getRelationColumnFromMethodName($method);

                    if (!$column) {
                        throw new \Exception("You have wrong PHPDoc in " . $method->class . " class");
                    }

                    $preparedData = $this->getPreparedData($method, $column);
                    $preparedData['model_list_id'] = $model->id;

                    $prepareColumns[] = $preparedData;
                }

                ModelFieldReference::query()->insert($prepareColumns);
            });
    }

    private function getReturnTypeName(ReflectionIntersectionType|ReflectionNamedType|ReflectionUnionType|null $type): bool|string
    {
        if (is_null($type)) {
            return false;
        }


        return class_basename($type->getName());
    }

    private function getRelationColumnFromDocComment($docComment): array|string|bool
    {
        $stringObject = Str::of($docComment);

        if ($stringObject->contains($this->morphRelationColumnDoc)) {
            $column = $stringObject->after($this->morphRelationColumnDoc)
                ->before(PHP_EOL)
                ->trim()
                ->singular()
                ->toString();

            return [
                "model_field_id" => null,
                "foreign_model_field_id" => "{$column}_id",
                "foreign_model_field_type" => "{$column}_type",
            ];
        }

        if ($stringObject->contains($this->relationColumnDoc)) {
            return $stringObject->after($this->relationColumnDoc)
                ->before(PHP_EOL)
                ->trim()
                ->singular()
                ->toString();
        }

        return false;
    }

    private function getRelationColumnFromMethodName(ReflectionMethod $method): array|string
    {
        $column = Str::singular($method->getName());

        if ($method->getReturnType()->getName() === MorphTo::class) {
            return [
                "model_field_id" => null,
                "foreign_model_field_id" => "{$column}_id",
                "foreign_model_field_type" => "{$column}_type",
            ];
        }

        return "{$column}_id";
    }

    private function getPreparedData(ReflectionMethod $method, bool|array|string $column): bool|array
    {

        if (is_string($column)) {

            if ($method->getReturnType()->getName() == BelongsToMany::class) {
                $localForeignKey = Str::of($method->class)->classBasename()->lower()->singular()->toString();
                return [
                    "relation_type" => $this->getReturnTypeName($method->getReturnType()),
                    "model_field_id" => "{$localForeignKey}_id",
                    "foreign_model_field_id" => $column,
                    "foreign_model_field_type" => null,
                ];
            }

            if (in_array($method->getReturnType()->getName(), [
                MorphTo::class,
                MorphOne::class,
                MorphToMany::class
            ])) {
                return [
                    "relation_type" => $this->getReturnTypeName($method->getReturnType()),
                    "model_field_id" => null,
                    "foreign_model_field_id" => "{$column}_id",
                    "foreign_model_field_type" => "{$column}_type",
                ];
            }
            return [
                "relation_type" => $this->getReturnTypeName($method->getReturnType()),
                "model_field_id" => "id",
                "foreign_model_field_id" => $column,
                "foreign_model_field_type" => null,
            ];

        }

        $column["relation_type"] = $this->getReturnTypeName($method->getReturnType());
        return $column;
    }
}
