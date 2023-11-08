# Kakinohatei-Sales-Backend

このアプリは、JA 鳥取イナバグループの直売所に商品を出荷している生産者向けの売上管理システムです。

## Overview

## Getting Start

開発には [Laravel Sail](https://readouble.com/laravel/9.x/ja/sail.html) を使用します.

```
# プロジェクトをpull後、Compoer依存関係のインストールしてください
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

# Laravel SetUp
cp .env.example .env
```

## Command

```
./vendor/bin/sail up -d                 Sailの立ち上げ
./vendor/bin/sail php artisan key:generate App Keyの生成
./vendor/bin/sail php artisan migrate   マイグレーションの実行
```

## 構文チェック&静的解析

### Remote に Push する前に実行してください

```
# PHPStan
./vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=2G

# Laravel Pint
./vendor/bin/pint
```

## .editorconfig

[`.editorconfig`](/.editorconfig) でインデントやスペースのルールを定義し、書くときにブレが生じないようにしています.

### Visual Studio Code

拡張機能 [EditorConfig for VS Code](https://marketplace.visualstudio.com/items?itemName=EditorConfig.EditorConfig)

## コミットメッセージルール

#### Prefix を先頭に付けてください

-   feat: 新しい機能
-   fix: バグの修正
-   docs: ドキュメントのみの変更
-   style: 空白、フォーマット、セミコロン追加など
-   refactor: 仕様に影響がないコード改善(リファクタ)
-   perf: パフォーマンス向上関連
-   test: テスト関連
-   chore: ビルド、補助ツール、ライブラリ関連
