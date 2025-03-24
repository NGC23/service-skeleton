<?php

declare(strict_types=1);

namespace Neil\Test\Application;

use Laminas\Diactoros\Response\JsonResponse;
use Neil\Config\Database\ConnectionFactoryInterface;
use Neil\Config\Database\DatabaseConnectionException;
use Neil\Config\Database\DatabaseConnectionFactory;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller
{
    public function __construct(private readonly ConnectionFactoryInterface $connectionFactory)
    {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        try {
            /** @var PDO $connection */
            $connection = ($this->connectionFactory->create());

            $connection->beginTransaction();

            $pstm = $connection->prepare('SELECT * FROM test');

            $pstm->execute();

            $result = $pstm->fetchAll(PDO::FETCH_ASSOC);


            $connection->commit();
        } catch (DatabaseConnectionException $e) {
          die('error');
        }

        return new JsonResponse($result);
    }
}