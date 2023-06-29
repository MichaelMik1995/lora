#!/bin/bash

cd "$(dirname "$(realpath "$0")")";
echo Welcome To LORA Framework server!
php -S localhost:8082;

