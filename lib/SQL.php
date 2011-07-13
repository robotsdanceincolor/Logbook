<?php

abstract class SQL
{
    public static $pdo = null;

    public function connect()
    {
        self::$pdo = new PDO(SQL_DSN,SQL_USER,SQL_PASS);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    public function query($query,$kvp = array())
    {
        try
        {
            if (self::$pdo == null)
            {
                echo 'SQL: You forgot to connect.';
                return;
            }

            $stmt = self::$pdo->prepare($query);
            $stmt->execute($kvp);

            $data = array();

            $type = explode(' ', $query);
            $type = $type[0];
            $data = null;
            switch ($type)
            {
                case 'SHOW':
                case 'SELECT':
                    $data = array();
                    while ($row = $stmt->fetch())
                        $data[] = $row;
                    break;
                case 'DELETE':
                case 'INSERT':
                case 'UPDATE':
                    $data = $stmt->rowCount();
                    break;
            }
            return $data;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}

?>
