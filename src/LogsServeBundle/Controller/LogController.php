<?php

namespace LogsServeBundle\Controller;

use LogsServeBundle\Exception\ReaderException;
use LogsServeBundle\Reader\FileReader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LogController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $key = $request->get('KEY', null);
        $secretKey = $this->getParameter('logs_serve.secret_key');

        if ($key != $secretKey) {
            return JsonResponse::create(['Error' => 'Access denied']);
        }

        $parameters = $this->getParameter('logs_serve.logs');
        /** @var FileReader $fileReader */
        $fileReader = $this->get('logs_serve.file_reader');

        foreach ($parameters as $name => $parameter) {
            try {
                $data = $fileReader->read($parameter['path'], $parameter['lines']);
            } catch (ReaderException $e) {

                return JsonResponse::create(['Error' => $e->getMessage()]);
            }

            $logs[] = [
                'name' => $name,
                'logs' => $data
            ];
        }

        $response = isset($logs) ? $logs : [];

        return JsonResponse::create($response);
    }
}
