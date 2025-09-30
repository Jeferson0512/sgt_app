<?php

// declare(strict_types=1);
final class RespuestaDTO
{
    public function __construct(
        public bool $success,
        public string $mensaje,
        public array $errors = [],
        public mixed $datos = null,
        public ?string $codigo = '',
        public ?string $titulo = null,
    ) {}

    // public function respuestaJSON(): array
    // {
    //     return [
    //         'success' => $this->success,
    //         'titulo' => $this->titulo,
    //         'mensaje' => $this->mensaje,
    //         'datos' => $this->datos,
    //     ];
    // }
    public static function ok(string $message, mixed $data = null, string $codigo = ''): self
    {
        return new self(true, $message, [], $data, $codigo);
    }

    public static function error(string $message, array $errors = []): self
    {
        return new self(false, $message, $errors, null);
    }
}
