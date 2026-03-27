# itFrog
Сайт для IT-школы программирования для записи учеников, записи администратором в нужный филиал, просмотра расписания учителя, онлайн-оплаты родителям



## Установка (Linux) с нуля через Laravel Sail

Запуск проекта реализован с помощью **Laravel Sail** — обёртки над Docker Compose.

### Шаг 1. Установка Docker и Docker Compose

```bash
# Обновление пакетов
sudo apt update && sudo apt upgrade -y

# Установка Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
rm get-docker.sh

# Добавление пользователя в группу docker (чтобы не использовать sudo)
sudo usermod -aG docker $USER

# Применение изменений (или перезайдите в систему)
newgrp docker
```

**Проверка установки:**
```bash
docker --version
docker compose version
```

### Шаг 2. Клонирование проекта

```bash
git clone https://github.com/S0Artem/itFrog.git
cd itFrog
```

### Шаг 3. Настройка окружения

```bash
# Копирование файла окружения
cp .env.example .env

# При необходимости отредактируйте .env (порт, база данных и т.д.)
nano .env
```

### Шаг 4. Установка зависимостей и запуск

```bash
# Установка Composer-зависимостей
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# Запуск Sail (поднимает все сервисы: Laravel, MySQL, Redis, phpMyAdmin)
./vendor/bin/sail up -d
```

### Шаг 5. Инициализация приложения

```bash
# Генерация ключа приложения
./vendor/bin/sail artisan key:generate

# Миграция базы данных
./vendor/bin/sail artisan migrate
```

## Доступ к сервисам

| Сервис | URL | Примечание |
|--------|-----|------------|
| Приложение | http://localhost | Основной сайт |
| phpMyAdmin | http://localhost:8081 | Управление БД (логин из `.env`) |

## Сборка frontend (при изменениях в JS/CSS)

```bash
# Установка Node.js зависимостей
./vendor/bin/sail npm install

# Сборка для продакшена
./vendor/bin/sail npm run build

# Режим разработки (watch)
./vendor/bin/sail npm run dev
```