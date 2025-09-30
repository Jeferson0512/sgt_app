<?php

final class CorrectivoValidator
{

    public static function validateCreate(array $input): array
    {
        $errors = [];

        $titulo = trim($input['titulo'] ?? '');
        $sentido = strtoupper(trim($input['sentido'] ?? ''));
        $responsable = trim($input['responsable'] ?? '');

        if ($titulo === '' || mb_strlen($titulo) < 3) {
            $errors['titulo'] = 'El título es obligatorio y debe tener al menos 3 caracteres.';
        }
        if (!in_array($sentido, ['NORTE', 'SUR'], true)) {
            $errors['sentido'] = 'El sentido debe ser NORTE o SUR.';
        }
        if ($responsable === '' || mb_strlen($responsable) < 3) {
            $errors['responsable'] = 'El responsable es obligatorio.';
        }

        // (Opcional) más reglas de negocio: longitudes máximas, listas permitidas, etc.

        return $errors;
    }

    public static function validate(array $data): void
    {
        if (!isset($data['equipo_id']) || !is_numeric($data['equipo_id'])) {
            throw new \InvalidArgumentException("equipo_id inválido");
        }

        if (empty($data['descripcion'])) {
            throw new \InvalidArgumentException("La descripción es obligatoria");
        }

        if (!isset($data['fecha_reporte']) || !strtotime($data['fecha_reporte'])) {
            throw new \InvalidArgumentException("La fecha no es válida");
        }
    }
}
