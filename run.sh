#!/bin/bash

cd "$(dirname "$(realpath "$0")")";
echo Welcome To LORA Framework server - version 3.2!
php -S localhost:8082;

