<?php

use Phinx\Migration\AbstractMigration;

class CreateTableProfile extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     */
    public function change()
    {
        if ($this->hasTable('profile')) {
            return;
        }
        $this->table('profile')
             ->addColumn('fullname', 'string', ['limit' => 50])
             ->addColumn('dob', 'date')
             ->addColumn('email', 'string', ['limit' => 150])
             ->create();
    }
}
