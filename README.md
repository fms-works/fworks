# CMPⅡ (タイトル未定)

### 画像投稿の部分はChromeとFirefoxしか動作しません(1/2時点)

## 開発
.envファイルを作成し、必要な変数を登録する
```sh
$ cp .env.sample .env
```

## 概略図

![概略図](https://user-images.githubusercontent.com/21101122/34324632-433dcc46-e8bd-11e7-9cc3-893aff638a5e.jpg)

## 機能

- twitterで認証するユーザー機能
- ユーザーの名前やプロフィールを編集、削除する
- 作品を投稿、編集、削除する
- 作品に対してコメントする機能
- 作品に対していいねする機能
- 作品に対してタグ付けでき、そのタグから作品を検索できる機能

## DB設計 (変更する可能性あり)

### Users

|カラム名|型|オプション|
|:-:|:-:|:-:|
|id|int|primary key, autoincrement|
|token|varchar(60)|not null|
|token_secret|varchar(60)|not null|
|screen_name|varchar(20)|not null|
|name|varchar(25)|not null|
|profile|text||
|github_account|varchar(25)||
|avatar|text||
|created_at|datetime|not null|

## Works

|カラム名|型|オプション|
|:-:|:-:|:-:|
|id|int|primary key, autoincrement|
|title|varchar(25)|not null|
|link|text||
|detail|text|not null||
|user_id|int|not null, index|
|created_at|datetime|not null||
|updated_at|datetime|not null|

## WorkImages

|カラム名|型|オプション|
|:-:|:-:|:-:|
|id|int|primary key, autoincrement|
|content|text|not null|
|main|tinyint|not null, default: 0|
|user_id|int|not null, index|
|work_id|int|not null, index|
|created_at|datetime|not null|

## Comments

|カラム名|型|オプション|
|:-:|:-:|:-:|
|id|int|primary key, autoincrement|
|content|text|not null|
|user_id|int|not null, index|
|work_id|int|not null, index|
|created_at|datetime|not null|

## Likes

|カラム名|型|オプション|
|:-:|:-:|:-:|
|id|int|primary key, autoincrement|
|user_id|int|not null, index|
|work_id|int|not null, index|
|created_at|datetime|not null|

## Tags

|カラム名|型|オプション|
|:-:|:-:|:-:|
|id|int|primary key, autoincrement|
|name|varchar(20)|not null, index|
|created_at|datetime|not null|

## WorkTags

|カラム名|型|オプション|
|:-:|:-:|:-:|
|id|int|primary key, autoincrement|
|work_id|int|not null, index|
|tag_id|int|not null, index|
|created_at|datetime|not null|
