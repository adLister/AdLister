<?php
require_once 'Model.php';

class User extends Model
{
    protected static $table = 'contacts';

	public static function find($id)
	{
        self::dbConnect();
        $query = 'SELECT * FROM contacts WHERE id = :id';
    	$stmt = self::$dbc->prepare($query);
    	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
    	$stmt->execute();
    	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $instance = null;
        if ($result) {
            $instance = new static;
            $instance->attributes = $result;
        }
        return $instance;
	}

    // Get all rows from contacts table
    public static function all()
    {
        self::dbConnect();

        // get all rows
        $stmt = self::$dbc->query('SELECT * FROM contacts');

        // Assign result to variable
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // <-- this is okay because there's not a prepared statement
        return $result;
    }

    public function save()
    {
        // Ensure there are attributes before attempting to save
        if (isset($this->attributes)){
    
            if (isset($this->attributes['id'])){
            // Perform the proper action - if the `id` is set, this is an update, if not it is a insert
                $this->update();
            } else {
                $this->insert();
            }
        }
    }

    public function update()
    {
        $query = 'UPDATE contacts
                SET first_name = :first_name, 
                    last_name = :last_name,
                    email = :email,
                    phone = :phone
                    WHERE id = :id';
        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':first_name', $this->attributes['first_name'], PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $this->attributes['last_name'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->attributes['email'], PDO::PARAM_STR);
        $stmt->bindValue(':phone', $this->attributes['phone'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->attributes['id'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public function insert()
    {
        $query = 'INSERT INTO contacts (first_name, last_name, email, phone) VALUES (:first_name, :last_name, :email, :phone)';
        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':first_name', $this->attributes['first_name'], PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $this->attributes['last_name'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->attributes['email'], PDO::PARAM_STR);
        $stmt->bindValue(':phone', $this->attributes['phone'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public function delete()
    {
        $query = 'DELETE FROM contacts WHERE id = :id';
        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

// $user = User::all(1);
// var_dump($user);

$user = new User;
$user->first_name = 'Jim';
$user->last_name = 'Halpert';
$user->email = 'jimHalpert@dundermufflin.net';
$user->phone = '904-555-2590';

$user->update();

$user2 = new User;
$user2->first_name = 'Dwight';
$user2->last_name = 'Shrute';
$user2->email = 'dwightShrute@dundermifflin.net';
$user2->phone = '758-555-0987';

$user2->update();
