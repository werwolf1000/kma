<?php

namespace vendor;

interface IRabbitMQHandler
{
    public function handler(string $message);
}