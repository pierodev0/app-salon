<?php
namespace Helpers;
class JsonResponse
{
    private static int $statusCode = 200;
    private static array $headers = [];
    private static array $data = [];

    /**
     * Establece el código de estado HTTP.
     *
     * @param int $statusCode
     * @return self
     */
    public static function status(int $statusCode): self
    {
        self::$statusCode = $statusCode;
        return new self;
    }

    /**
     * Agrega un encabezado HTTP.
     *
     * @param string $key
     * @param string $value
     * @return self
     */
    public static function header(string $key, string $value): self
    {
        self::$headers[$key] = $value;
        return new self;
    }

    /**
     * Establece los datos para la respuesta.
     * Si los datos contienen la clave "status" con un valor numérico,
     * se utiliza como código de estado HTTP.
     *
     * @param array $data
     * @return self
     */
    public static function data(array $data): self
    {
        self::$data = $data;

        if (isset($data['status']) && is_int($data['status'])) {
            self::$statusCode = $data['status'];
        }

        return new self;
    }

    /**
     * Envía la respuesta JSON al cliente.
     *
     * @return void
     */
    public static function send(): void
    {
        // Configura el código de estado HTTP
        http_response_code(self::$statusCode);

        // Configura los encabezados predeterminados
        header('Content-Type: application/json');

        // Configura los encabezados adicionales
        foreach (self::$headers as $key => $value) {
            header("$key: $value");
        }

        // Convierte los datos a JSON y los imprime
        echo json_encode(self::$data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit; // Finaliza la ejecución del script
    }
}