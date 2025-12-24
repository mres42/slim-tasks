<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserTaskTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('user_tasks', [
            'id' => false,
            'primary_key' => ['user_id', 'task_id'],
        ]);

        $table
            ->addColumn('user_id', 'biginteger', [
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('task_id', 'biginteger', [
                'null' => false,
                'signed' => false,
            ])
            ->addTimestamps()

            ->addIndex(['user_id'])
            ->addIndex(['task_id'])

            ->addForeignKey(
                'user_id',
                'users',
                'id',
                ['delete' => 'CASCADE', 'update' => 'NO_ACTION']
            )
            ->addForeignKey(
                'task_id',
                'tasks',
                'id',
                ['delete' => 'CASCADE', 'update' => 'NO_ACTION']
            )

            ->create();
    }
}
