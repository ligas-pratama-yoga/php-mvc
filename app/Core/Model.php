<?php

namespace App\Core;

use PDOStatement;

/**
 * @method PDOStatement|bool query()
 * @method static PDOStatement|bool query()
 * @method array all()
 * @method static array all(?array $params, ?array $condition):, bool|array
 * @method array|bool find()
 * @method static array|bool find()
 * @method array findOrFail()
 * @method static array findOrFail()
 * @method array structure()
 * @method static array structure()
 * @method bool create()
 * @method static bool create()
 * @method bool update()
 * @method static bool update()
 * @method bool delete()
 * @method static bool delete()
 */
class Model
{
	public string $table;
	public PDOStatement|null|bool $statement = null;
	public Database $db;

	// Connect to the database
	public function __construct()
	{
		$this->db = new Database();
		$this->table ??= $this->getTable();
	}
	public function _query(string $sql, ?array $params = []): \PDOStatement|bool
	{
		$this->statement = $this->db->connection->prepare($sql);
		$this->statement->execute($params);
		return $this->statement;
	}
	/**
	 * @param mixed $params
   * @return string
	 */
	private function params(?array $params = []): string
	{
		return implode(",", ($params == []) ? $this->_structure() : $params);
	}
	/*
 * *
	 * @return array
	 */
	public function _all(?array $params = [], ?array $condition = []): array|bool
	{
		if ($condition !== []) {
			$where = "";
			$x = 0;
			$names = array_keys($condition);

			foreach ($names as $name) {
				$where .= "{$name} = :{$name}";
				if ($x < count($condition) - 1) {
					$where .= ',';
				}
				$x++;
			}
			$this->_query("SELECT {$this->params($params)} FROM $this->table where {$where}", $condition);
			return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
		}
		$this->_query("SELECT {$this->params($params)} FROM $this->table");
		return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function _find(int $id, ?array $params = []): array|bool
	{
		$params = $params == [] ? $this->params() : $params;
		$this->_query("select {$params} from {$this->getTable()} where id=?", [$id]);
    $result = $this->statement->fetch(\PDO::FETCH_ASSOC);
		return $result;
	}
    /**
     * @return array|bool
     */
    public function _findOrFail(int $id, ?array $params = []): array
  {
    $result = $this->_find($id, $params);

    if(!$result){
      return abort();
    }

    return $result;
  }


	public function _structure(): array
	{
		$this->_query("describe $this->table");
		return $this->statement->fetchAll(\PDO::FETCH_COLUMN);
	}

	/**
	 * @param array<int,mixed> $values
	 */
	public function _create(array $values): bool
	{
		$keys = array_keys($values);
		$columns = implode(",", $keys);
		$wildcards = "";
		$x = 0;
		foreach ($keys as $key) {
			$wildcards .= ":{$key}";
			if ($x < count($keys) - 1) {
				$wildcards .= ",";
			}
			$x++;
		}
		return $this->_query("insert into {$this->table}($columns) values({$wildcards})", $values) === null ? false : true;
	}
	/**
	 * @return bool
	 * @param array<int,mixed> $sets
	 */
	public function _update(int $id, array $sets): bool
	{
		$set = '';
		$x = 0;
		$names = array_keys($sets);

		foreach ($names as $name) {
			$set .= "{$name} = :{$name}";
			if ($x < count($sets) - 1) {
				$set .= ',';
			}
			$x++;
		}

		$sets["id"] = $id;

		$sql = "UPDATE {$this->table} SET {$set} WHERE id = :id";
		if ($this->_query($sql, $sets)) {
			return true;
		}

		return false;
	}
	/**
	 * @return bool
	 */
	public function _delete(int $id): bool
	{
		if (!$this->_query("delete from {$this->table} where id = ?", [$id])) {
			return false;
		}
		return true;

	}
	/**
	 * @return string
	 */
	public function getTable(): string
	{
		$arr = explode("\\", get_class($this));
		/*return $this->table ?? strtolower($arr[count($arr) - 1]);*/
		return strtolower($arr[array_key_last($arr)]);
	}

	/**
	 * @param mixed $arguments
	 */
	public function __call(string $name, $arguments): mixed
	{
		$name = "_" . $name;
		return $this->{$name}(...$arguments);
	}
	/**
	 * @param mixed $arguments
	 */
	public static function __callStatic(string $name, $arguments): mixed
	{
		return (new static())->{$name}(...$arguments);
	}
}
