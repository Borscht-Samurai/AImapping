# AI Mapping Theme

AIを活用するクリエイター向け募集掲示板型プラットフォームのWordPressテーマ

## 🎯 プロジェクト概要

AI Mappingは、AIを活用するクリエイター同士が日本全国（またはオンライン）で自由に集まり交流できる募集掲示板型プラットフォームです。meetupのように自由にイベントや交流会を開催でき、クリエイター同士が繋がれる場所を提供します。

### 主な特徴
- 🎨 ニューモーフィズムデザインを採用した美しいUI
- 📱 完全レスポンシブ対応
- 🔐 SNS連携ログイン（Google、Facebook、Twitter）
- 💬 リアルタイムいいね機能（AJAX）
- 🗓️ イベント管理機能
- 👥 ユーザープロフィール機能

## 📁 ディレクトリ構造

```
aimapping-theme/
├── 📄 style.css                    # メインスタイルシート（テーマ情報含む）
├── 📄 functions.php                # テーマの主要機能定義
├── 📄 index.php                    # 基本テンプレート
├── 📄 header.php                   # ヘッダーテンプレート
├── 📄 footer.php                   # フッターテンプレート
├── 📄 sidebar.php                  # サイドバーテンプレート
├── 📄 404.php                      # 404エラーページ
├── 📄 README.md                    # このファイル
│
├── 📂 template-parts/              # 再利用可能なテンプレートパーツ
│   ├── 📄 content-post.php        # 投稿詳細の表示
│   ├── 📄 content-card.php        # 募集カードの表示
│   ├── 📄 comment-template.php    # コメントテンプレート
│   └── 📄 profile-template.php    # プロフィールページテンプレート（ユーザー表示・編集機能統合）
│
├── 📂 page-templates/              # カスタムページテンプレート
│   ├── 📄 contact-template.php    # お問い合わせページ
│   ├── 📄 login-template.php      # ログインページ
│   ├── 📄 register-template.php   # 会員登録ページ
│   ├── 📄 new-post-template.php   # 新規投稿/編集ページ
│   ├── 📄 edit-post-template.php  # 投稿編集ページ
│   ├── 📄 edit-profile.php        # プロフィール編集ページ
│   ├── 📄 faq-template.php        # FAQページ
│   ├── 📄 privacy-policy-template.php  # プライバシーポリシー
│   ├── 📄 terms-of-service-template.php # 利用規約
│   └── 📄 page-chip.php           # チップ（支援）ページ
│
├── 📂 js/                          # JavaScriptファイル
│   ├── 📄 script.js               # いいね機能などのメインスクリプト
│   └── 📄 main.js                 # モバイルメニューなどの追加機能
│
├── 📂 images/                      # 画像ファイル
│   ├── 📄 Logo.png                # サイトロゴ
│   ├── 📄 Rectangle1.png          # 募集カード背景画像
│   ├── 📄 frontpage-*.png         # フロントページ用画像
│   └── 📄 その他アイコン画像
│
├── 📂 .cursor/rules/               # Cursor AI用設定
│   └── 📄 .mdc                    # プロジェクト設定
│
├── 📄 front-page.php              # トップページテンプレート
├── 📄 page.php                    # 固定ページテンプレート
├── 📄 single-recruitment.php      # 募集詳細ページ
├── 📄 archive-recruitment.php     # 募集一覧ページ
├── 📄 author.php                  # ユーザープロフィールページ
├── 📄 page-user.php               # マイページ
├── 📄 page-faq.php                # FAQページ（ルート）
└── 📄 comments.php                # コメントテンプレート
```

## 📋 主要ファイルの機能説明

### コアファイル

#### `functions.php`
テーマの中核となる機能を定義。以下の主要機能を含む：
- テーマサポート機能の設定
- カスタム投稿タイプ「recruitment」の登録
- カスタムタクソノミー「recruitment_category」の登録
- AJAX処理（いいね機能、コメント編集・削除）
- ユーザー認証・登録処理
- 投稿の閲覧数カウント機能
- カスタムアバター機能
- 検索フィルター処理

#### `style.css`
- CSS変数による統一的なデザインシステム
- ニューモーフィズムデザインの実装
- レスポンシブ対応のスタイル
- 各ページ固有のスタイル定義

### テンプレートファイル

#### 投稿関連
- **`single-recruitment.php`**: 募集詳細ページの表示
  - グラデーションヘッダー
  - 開催情報の表示
  - いいね/SNSシェア機能
  - 編集・削除ボタン（投稿者のみ）

- **`archive-recruitment.php`**: 募集一覧ページ
  - カテゴリー/場所/形式での絞り込み
  - 並び替え機能（新着/閲覧数/いいね数）
  - カード形式での募集表示

#### ユーザー関連
- **`author.php`**: 他ユーザーのプロフィール表示
- **`page-user.php`**: ログインユーザーのマイページ
- **`template-parts/profile-template.php`**: ユーザープロフィール表示
  - 自分のプロフィール表示
  - 他ユーザーのプロフィール表示
  - プロフィール情報の表示
  - フォロー機能
  - 最近の募集表示
  - SNSリンク表示

#### ページテンプレート
- **`front-page.php`**: トップページ
  - ヒーローセクション
  - サービス紹介
  - 最新募集の表示

- **`page-templates/new-post-template.php`**: 募集の新規作成/編集
  - リッチテキストエディタ
  - 画像挿入機能
  - プレビュー機能
  - 開催形式の選択（オンライン/オフライン）

### JavaScriptファイル

#### `js/script.js`
- いいね機能のAJAX処理
- ハートアニメーション
- ログイン誘導機能

#### `js/main.js`
- モバイルメニューの開閉
- スクロールトップボタン
- レスポンシブ対応の処理

## 🛠️ 技術スタック

- **CMS**: WordPress 5.0+
- **PHP**: 7.4+
- **JavaScript**: ES6+（jQuery使用）
- **CSS**: CSS3（CSS変数使用）
- **デザイン**: ニューモーフィズム
- **フォント**: Noto Sans JP, Poppins
- **アイコン**: Font Awesome 5

## 🚀 主な機能

### 1. 募集管理機能
- カスタム投稿タイプによる募集管理
- カテゴリー分類
- 開催日時・場所の管理
- オンライン/オフライン形式の選択

### 2. ユーザー機能
- SNS連携ログイン
- プロフィール管理
- 投稿履歴の表示
- フォロー機能（実装準備済み）

### 3. インタラクション機能
- Ajax対応のいいね機能
- コメント機能（編集・削除可能）
- SNSシェア機能
- 閲覧数カウント

### 4. 検索・フィルター機能
- カテゴリー別フィルター
- 開催形式での絞り込み
- 都道府県別フィルター
- 並び替え機能

## 📝 カスタマイズ方法

### テーマカラーの変更
`style.css`の`:root`セクションで定義されているCSS変数を編集：

```css
:root {
    --theme-color-1: #FF966C;  /* メインカラー */
    --theme-color-2: #A5FDF7;  /* サブカラー */
    --background-color: #E7E7E7; /* 背景色 */
}
```

### カスタム投稿タイプの追加
`functions.php`の`aimapping_register_post_types()`関数を参考に新しい投稿タイプを追加できます。

### 新しいページテンプレートの追加
1. `page-templates/`フォルダに新しいPHPファイルを作成
2. ファイルの先頭に`Template Name:`を記述
3. `functions.php`の`register_custom_page_templates()`に登録

## 🔧 必要なプラグイン

### 推奨プラグイン
- **Contact Form 7**: お問い合わせフォーム機能
- **Advanced Custom Fields**: カスタムフィールド管理（オプション）
- **WP Social Login**: SNS連携ログイン機能

## 📱 レスポンシブ対応

以下のブレークポイントで最適化：
- **デスクトップ**: 1200px以上
- **タブレット**: 768px - 1199px
- **スマートフォン**: 767px以下

## 🚦 開発環境

### 推奨環境
- **ローカル開発**: LocalWP
- **エディタ**: Cursor（AI支援機能付き）
- **PHP**: 7.4以上
- **MySQL**: 5.7以上

## 📄 ライセンス

GPL v2またはそれ以降のバージョン

## 👥 貢献方法

1. このリポジトリをフォーク
2. 機能ブランチを作成 (`git checkout -b feature/AmazingFeature`)
3. 変更をコミット (`git commit -m 'Add some AmazingFeature'`)
4. ブランチにプッシュ (`git push origin feature/AmazingFeature`)
5. プルリクエストを作成

## 📞 サポート

- **メール**: aimapping21@gmail.com
- **Issue**: GitHubのIssueで報告してください

## 🎉 今後の開発予定

- [ ] メッセージ機能の実装
- [ ] 通知機能の追加
- [ ] PWA対応
- [ ] 多言語対応
- [ ] AIによる募集のマッチング機能

---

*AIを活用するクリエイターのための、クリエイターによるプラットフォーム*