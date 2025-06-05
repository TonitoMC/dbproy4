<?php

namespace App\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
class ApiResponseClass
{
    /**
     * Rolls back the database transaction and throws a JSON response exception.
     *
     * @param \Throwable $e The exception to log.
     * @param string $message The message to return in the JSON response.
     * @return void
     *
     * @throws HttpResponseException
     */
    public static function rollback($e, $message = 'No se pudo completar la transacción'): void
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    /**
     * Logs the exception and throws a JSON response exception.
     *
     * @param \Throwable $e The exception to log.
     * @param string $message The message to return in the JSON response.
     * @return void
     *
     * @throws HttpResponseException
     */
    public static function throw($e, $message = 'Algo salió mal en la petición'): void
    {
        Log::info($e);
        throw new HttpResponseException(response()->json(['message'=> $message], 500));
    }

    /**
     * Sends a standard JSON response.
     *
     * @param mixed $result The data to include in the response.
     * @param string|null $message The message to include in the response.
     * @param int $code The HTTP status code for the response.
     * @return JsonResponse
     */
    public static function respondWithJSON($result , $message ,$code=200): JsonResponse
    {
        $response=[
            'success' => true,
            'data'    => $result
        ];
        if(!empty($message)){
            $response['message'] =$message;
        }
        return response()->json($response, $code);
    }

}
