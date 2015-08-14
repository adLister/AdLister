<?php
require_once 'Model.php';
class Ad extends Model
{
    public static $table = 'ads';

	public static function find($id)
	{
        self::dbConnect();
        $query = 'SELECT * FROM ads WHERE id = :id';
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

    public static function categorySearch($search)
    {
        self::dbConnect();

        $query = 'SELECT * FROM ads WHERE category = :search';
        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':search', $search, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $instance = null;
        if ($result)
        {
            $instance = new static;
            $instance->attributes = $result;
        }
        return $instance;
    }

    public static function userSearch($search)
    {
        self::dbConnect();

        $query = 'SELECT * FROM ads WHERE posting_user = :search';
        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':search', $search, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $instance = null;
        if ($result)
        {
            $instance = new static;
            $instance->attributes = $result;
        }
        return $instance;
    }

    public static function idSearch($search)
    {
        self::dbConnect();

        $query = 'SELECT * FROM ads WHERE id = :search';
        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':search', $search, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $instance = null;
        if ($result)
        {
            $instance = new static;
            $instance->attributes = $result;
        }
        return $instance;
    }

    public static function paginateUserAds($limit, $offset, $user)
    {
        self::dbConnect();

        $stmt = self::$dbc->prepare("SELECT * FROM ads WHERE posting_user = :posting_user LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':posting_user', $user, PDO::PARAM_INT);
        $stmt->execute();
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $count = self::$dbc->query('SELECT count(*) FROM ads');
        $stmt1 = $count->fetchColumn();
        $maxpage = ceil($stmt1 / $limit);

        $instance = null;
        if ($result)
        {
            $instance = new static;
            $instance->attributes = $result;
            $instance->attributes['maxpage'] = $maxpage;
        }
        return $instance;
    }

    // Get all rows from users table
    public static function all()
    {
        self::dbConnect();

        // get all rows
        $stmt = self::$dbc->query('SELECT * FROM ads');

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
        $query = 'UPDATE ads
                SET date_created = :date_created, 
                    description = :description,
                    image_url = :image_url,
                    category = :category,
                    title = :title,
                    posting_user = :posting_user
                    WHERE id = :id';
        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':date_created', $this->attributes['date_created'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->attributes['description'], PDO::PARAM_STR);
        $stmt->bindValue(':image_url', $this->attributes['image_url'], PDO::PARAM_STR);
        $stmt->bindValue(':category', $this->attributes['category'], PDO::PARAM_STR);
        $stmt->bindValue(':title', $this->attributes['title'], PDO::PARAM_STR);
        $stmt->bindValue(':posting_user', $_SESSION['email'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public function insert()
    {
        $query = 'INSERT INTO ads (title, date_created, description, image_url, category)
                VALUES (:title, :date_created, :description, :image_url, :category)';
        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':title', $this->attributes['title'], PDO::PARAM_STR);
        $stmt->bindValue(':date_created', $this->attributes['date_created'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->attributes['description'], PDO::PARAM_STR);
        $stmt->bindValue(':image_url', $this->attributes['image_url'], PDO::PARAM_STR);
        $stmt->bindValue(':category', $this->attributes['category'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function delete($id)
    {
        self::dbConnect();
        $query = 'DELETE FROM ads WHERE id = :id';
        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}