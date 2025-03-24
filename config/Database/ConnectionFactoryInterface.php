<?php

namespace Neil\Config\Database;

interface ConnectionFactoryInterface
{
    public function create(): object;
}