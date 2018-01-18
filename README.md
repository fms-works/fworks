# FWorks
FMS学生のための作品投稿サービス

![home](https://user-images.githubusercontent.com/21101122/35085560-9895c0be-fc6c-11e7-952c-52e1030b02a2.jpg)

# 概要
FWorksはFMSの学生が自由に作品を投稿し合うことができるサービスです。

タイトルとメイン画像、詳細を入力するだけで簡単に自分の作品を公開できます。

FWorksを使うことで、過去の先輩の作品や授業で他の人達が作ったプロダクトを探すこともできます。

## 機能一覧
- ユーザー認証(TwitterOAuth)
- ユーザー編集/削除
- 作品投稿/編集/削除
- OpenProcessing、YouTube野埋め込み
- タグ付け機能
- いいね、コメント機能

# 開発
FWorksは、FMS学生なら誰でも開発することができ、追加機能やバグ修正など、なんでも受け付けています！

みんなでより良いものを作っていきましょう！

[ebkn12](https://github.com/ebkn12) や [Turtley60537](https://github.com/Turtley60537) などfms-worksの管理者に依頼して、Organizationに招待してもらってください！

## 環境
バージョンが古いので気をつけてください

```
php 5.3.3 (php7系の構文などが使えないので注意してください)
MySQL 5.0.67
Apache 2.2.27
```

## 1. ローカルにリポジトリをダウンロードする
```sh
# ssh
$ git clone git@github.com:fms-works/fworks.git

# https
$ git clone https://github.com/fms-works/fworks.git
```

## 2. TwitterのOAuth登録をする
https://apps.twitter.com/

`CONSUMER_KEY`と`CONSUMER_SECRET`をメモ。

`CALLBACK_URL`には、`user/callback.php`までのパスを指定してください

(例) http://localhost/fworks/user/callback.php

## 3. 自分の環境にMySQLを入れる
(既にインストールしてある人は飛ばしてください)

### Mac
homebrew (https://brew.sh/index_ja.html) を使っていれることをおすすめします

```sh
$ brew install mysql

$ mysql.server start
```

参考

https://qiita.com/griffin3104/items/c7908359a3e3e18cd269

### Windows

参考

https://webkaru.net/mysql/install-windows/

### Linux

yumなどを使ってインストールしてください

参考

http://www.miloweb.net/mysql.html


インストール時に設定したユーザーとパスワードをメモ。

デフォルトだと
```
user: root
password:
```
です

## 4. データベースを作成

MySQLにログインして、好きな名前でデータベースを作成してください。
```sh
$ mysql -u root
(パスワードを指定していたら mysql -u root -p)

> create database データベース名;
```

dumpファイルをimportしてください
```sh
$ mysql -u root データベース名 < dumpファイル
```

## 5. .envを設定する

.sample.envを元に.envファイルを作る
```sh
$ cp .env.sample .env
```

```
CONSUMER_KEY='<TwitterOAuthのconsumer key>'
CONSUMER_SECRET='<TwitterOAuthのConumer secret>'
OAUTH_CALLBACK='<user/callback.phpへのパス>'
DB_HOST='<データベースのホスト名(例: localhost)>'
DB_NAME='<データベース名(例: fworks_dev)>'
MYSQL_SOCKET='<Mac、Linuxユーザーは unix_socket=/tmp/mysql.sock; と記述してください(Windowsは空)>'
MYSQL_USER='<MySQLのユーザー名(例: root)>'
MYSQL_PASSWORD='<MySQLのパスワード(例: password)>'
```

## 5. 完了！
