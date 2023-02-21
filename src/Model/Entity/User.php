<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $username
 * @property string|null $email
 * @property string|null $password
 * @property string|null $enc_password
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'firstname' => true,
        'lastname' => true,
        'username' => true,
        'email' => true,
        'password' => true,
        'enc_password' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('firstname')
            ->notEmptyString('lastname')
            ->notEmptyString('username')
            ->notEmptyString('email')
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => 'Please enter a valid email address'
            ])
            ->notEmptyString('password')
            ->notEmptyString('enc_password');
        
        return $validator;
    }

    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }

}
