<?php

namespace Core;

class Validator
{
    protected array $errors = [];

    /**
     * Validates that a value is a non-negative number
     */
    public function validateNumber(string $field, $value, bool $allowFloat = true): bool
    {
        if ($allowFloat) {
            if (!is_numeric($value)) {
                $this->errors[$field][] = "The field $field must be a valid number.";
                return false;
            }
        } else {
            if (!ctype_digit((string) $value)) {
                $this->errors[$field][] = "The field $field must be a valid integer.";
                return false;
            }
        }

        if ($value < 0) {
            $this->errors[$field][] = "The field $field must be non-negative.";
            return false;
        }

        return true;
    }

    /**
     * Validates that a string is not empty
     */
    public function validateRequired(string $field, $value): bool
    {
        if (empty($value)) {
            $this->errors[$field][] = "The field $field is required.";
            return false;
        }

        return true;
    }

    /**
     * Validates that a string does not exceed a given length
     */
    public function validateMaxLength(string $field, string $value, int $maxLength): bool
    {
        if (strlen($value) > $maxLength) {
            $this->errors[$field][] = "The field $field must not exceed $maxLength characters.";
            return false;
        }

        return true;
    }

    /**
     * Validates that a value is within a certain range
     */
    public function validateRange(string $field, $value, $min, $max): bool
    {
        if ($value < $min || $value > $max) {
            $this->errors[$field][] = "The field $field must be between $min and $max.";
            return false;
        }

        return true;
    }

    /**
     * Checks if there are validation errors
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Retrieves validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Clears validation errors
     */
    public function clearErrors(): void
    {
        $this->errors = [];
    }
}
