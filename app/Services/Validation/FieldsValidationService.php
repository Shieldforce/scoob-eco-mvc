<?php

namespace ScoobEco\Services\Validation;

use ScoobEcoCore\Http\Request;

class FieldsValidationService
{
    private static bool   $validation = true;
    public static Request $request;

    public function __construct(Request $request)
    {
        self::$request = $request;
    }

    private static function setValidation($validation): void
    {
        self::$validation = $validation;
    }

    public static function getValidation(): bool
    {
        return self::$validation;
    }

    public static function rules(array $rules)
    {
        $rulesValidationsReturn = [];

        foreach ($rules as $fieldName => $fieldValidations) {
            $rulesValidationsReturn[$fieldName] = self::runRules($fieldName, $rules);
        }

        return $rulesValidationsReturn;
    }

    private static function runRules(string $fieldName, array $rules)
    {
        $runRules = [];
        foreach (glob(__DIR__ . '/*.php') as $file) {
            $fileName  = basename($file, '.php');
            $className = "ScoobEco\\Services\\Validation\\" . $fileName;
            $class     = new $className(self::$request, $rules);
            if (!self::classMatchField($class, $fieldName)) {
                continue;
            }

            $validationField = $class->{$fieldName}();

            if (!$validationField) {
                self::setValidation(false);
            }

            return $validationField;
        }

        return $runRules;
    }

    private static function classMatchField($class, $fieldName)
    {
        return method_exists($class::class, $fieldName);
    }

}