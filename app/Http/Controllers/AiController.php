<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function index()
    {
        return view('nexus.index');
    }

    public function generate(Request $request)
    {
        $prompt = $request->input('prompt');
        $apiKey = env('AI_PROVIDER_API_KEY');

        if (!$apiKey || str_starts_with($apiKey, 'sk-proj-ваш')) {
            return response()->json(['error' => 'API ключ не настроен в файле .env'], 500);
        }

        // Отправка запроса к реальному OpenAI API
        try {
            $response = Http::withToken($apiKey)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                // Обрати внимание: max_tokens не передаем или используем корректно, 
                // чтобы избежать старых ошибок совместимости моделей.
            ]);

            if ($response->successful()) {
                $aiReply = $response->json('choices.0.message.content');
                return response()->json([
                    'status' => 'success',
                    'response' => $aiReply
                ]);
            } else {
                return response()->json([
                    'error' => 'Ошибка от API нейросети: ' . $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Сетевая ошибка: ' . $e->getMessage()], 500);
        }
    }
}