<?php

use yii\db\Migration;

class m250507_165037_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'title' => $this->string(300)->notNull()->unique()
        ]);

        $tags = [
            'HTML', 'CSS', 'PHP', 'JAVASCRIPT', 'LINUX', 'WINDOWS', 'APACHE',
            'SQL', 'MYSQL', 'SQLSERVER', 'DOCKER', 'KUBERNETES', 'AWS', 'AZURE',
            'GIT', 'GITHUB', 'GITLAB', 'BITBUCKET', 'NPM', 'YARN', 'NODEJS',
            'REACT', 'VUE', 'ANGULAR', 'NEXTJS', 'NUXTJS', 'TAILWIND', 'BOOTSTRAP',
            'SASS', 'LESS', 'JSON', 'XML', 'API', 'REST', 'GRAPHQL', 'JWT',
            'CI/CD', 'UNIT TEST', 'SELENIUM', 'JENKINS', 'VSCODE', 'INTELLIJ',
            'PYTHON', 'JAVA', 'C#', 'C++', 'RUBY', 'PERL', 'LARAVEL', 'SYMFONY',
            'YII2', 'ZEND', 'SPRING', 'DJANGO', 'FLASK', 'EXPRESS', 'FASTAPI',
            'MONGODB', 'POSTGRES', 'SQLITE', 'REDIS', 'ELASTICSEARCH', 'NGINX',
            'APACHE TOMCAT', 'VAGRANT', 'ANSIBLE', 'TERRAFORM', 'LINUX SHELL',
            'BASH', 'POWERSHELL', 'XAMPP', 'WAMP', 'COMPOSER', 'MAKEFILE',
            'WEBPACK', 'ROLLUP', 'PARCEL', 'BABEL', 'ESLINT', 'PRETTIER',
            'TYPESCRIPT', 'ELECTRON', 'CORDOVA', 'CAPACITOR', 'FLUTTER', 'DART',
            'REACT NATIVE', 'UNITY', 'UNREAL', 'BLAZOR', 'SILVERLIGHT', 'UML',
            'SCRUM', 'KANBAN', 'JIRA', 'TRELLO', 'FIGMA', 'ADOBE XD', 'PHOTOSHOP'
        ];

        for ($i = 0; $i < count($tags); $i++) {
            $tags[$i] = [$tags[$i]];
        }

        $this->batchInsert('tag', ['title'], $tags);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tag');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250507_165037_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
