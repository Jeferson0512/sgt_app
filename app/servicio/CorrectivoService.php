<?php
require_once __DIR__ . '/../dto/CorrectivoDTO.php';
require_once __DIR__ . '/../dto/RespuestaDTO.php';
require_once __DIR__ . '/../models/CorrectivoModel.php';
// namespace app\core;

// use app\dto\CorrectivoDTO;

final class CorrectivoService
{
    private CorrectivoModel $model;

    public function __construct()
    {
        $this->model = new CorrectivoModel();
    }
    public function sListCorrectivo()
    {
        try {
            $rows = $this->model->mListCorrectivo();

            // Ejemplo: normalizaciones ligeras para el front (opcional)
            // mapear nombres, convertir fechas, etc.
            // Aquí lo dejo tal cual llega del SP.
            return RespuestaDTO::ok('OK', $rows);
        } catch (\Throwable $e) {
            return RespuestaDTO::error('Error al listar: ' . $e->getMessage());
        }
    }
    public function sCreateCorrectivo(CorrectivoDTO $dato): RespuestaDTO
    {
        $data = [
            'FechaMantto' => $dato->fecha,
            'CodTurno' => $dato->codturno,
            'CodSentido' => $dato->codsentido,
            'CodSistema' => $dato->codsistema,
            'CodTipoEquipo' => $dato->codtequipo,
            'CodEquipo' => $dato->codequipo,
            'CodPersonal' => $dato->codpersonal,
            'CodEstadoEquipo' => $dato->codestadoe,
            'Observaciones' => $dato->observaciones,
            'Estado' => $dato->estado,
            'UserCreate' => $dato->usercreate
        ];

        try {
            $codigo = $this->model->mCreateCorrectivo($data);

            if ($codigo == '' || $codigo == null) {
                return RespuestaDTO::error('El SP no creo el correctivo');
            }

            return RespuestaDTO::ok('Registrado Correctamente', ['codigo' => $codigo]);
        } catch (\Throwable $e) {
            return RespuestaDTO::error('Error al registrar: ' . $e->getMessage());
        }
    }
}
