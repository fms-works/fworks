# FWorks
FMS学生のための作品投稿プラットフォーム

#### ※画像投稿はChromeとFirefoxしか動作しません(1/10時点)

# 開発
.envファイルを作成
```sh
$ cp .env.sample .env
```

## 1. TwitterのOAuth登録をする
https://apps.twitter.com/

`CONSUMER_KEY`と`CONSUMER_SECRET`をメモ。

`CALLBACK_URL`には、`user/callback.php`までのパスを指定してください

(例) http://localhost/fworks/user/callback.php

## 2. 自分の環境にMySQLを入れる
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

## 3. データベースを作成

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

## 4. .envを設定する

.envに値を設定してください

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
