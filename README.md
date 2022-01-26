## JAinaba ERP

このアプリケーションは、JA鳥取イナバグループの直売所に商品を出荷している生産者向けの売上管理システムです。  
ユーザは、1時間ごとの売上をリアルタイムに確認することができます。（店舗の集計が１時間ごとに更新されるため）  
＃生産者向けのアプリケーションであるため、一般の方は通常の動作を確認することができません。  
＃一般の方は、デモページをご覧ください。

## 作成の背景や目的

製作者の実家では、米加工品（餅、おこわ、おはぎ）などを作って、JA鳥取いなばグループの直売所で販売しています。  
ＪＡ鳥取いなばでは、空メールをJA鳥取いなばに送信すると、売上情報がメールで送られてきます。  
そのため、最新の売上情報を取得するには、毎回空メールの送信をして、売上情報が返ってくるまで待たないといけません。  
本アプリでは、これら一連の動作をGmail APIによって、自動化することを目的として作成しました。

## 開発環境
### インフラ
AWS cloud9(EC2 instance type:t2.micro)

### フロントエンド
material-ui/core v4.12.3  
material-ui/icons v4.11.2  
material-ui/lab v4.0.0-alpha.60 extraneous  
bootstrap v4.6.1  
jquery v3.6.0  
react v16.14.0  
recharts v2.1.8

### バックエンド
PHP 7.2.24  
Laravel Framework 6.20.43

### データベース
MariaDB Server 0.2.38

### デプロイ
heroku (https://fierce-crag-96137.herokuapp.com/)

## デモページ
![dashboard](https://user-images.githubusercontent.com/41698195/151098367-47d0d487-a443-455e-b246-312570acc269.png)
