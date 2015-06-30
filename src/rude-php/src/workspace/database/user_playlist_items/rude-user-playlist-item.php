<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS'))             { define('RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS',             'user_playlist_items'); }
if (!defined('RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS_PRIMARY_KEY', 'id'); }

class user_playlist_item
{
	public $id          = null;
	public $playlist_id = null;
	public $song_id     = null;


	public function __construct($id = null)
	{
		if ($id)
		{
			$this->id = (int) $id;

			static::load($this->id);
		}
	}

	public function load($id = null)
	{
		if ($id === null)
		{
			$id = $this->id;
		}


		$q = new query_select(RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS);
		$q->where(RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS_PRIMARY_KEY, $id);
		$q->query();


		$item = $q->get_object();

		if (!$item)
		{
			return false;
		}


		foreach (get_object_vars($item) as $key => $val)
		{
			if (property_exists($this, $key))
			{
				$this->{$key} = $val;
			}
		}

		return true;
	}

	public function save()
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS);

		foreach (get_object_vars($this) as $field => $value)
		{
			if (isset($this->{$field}) and $this->{$field} !== null)
			{
				$q->add($field, $this->{$field});
			}
		}

		$q->query();

		return $q->get_id();
	}

	public function update()
	{
		$q = new query_update(RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS);

		foreach (get_object_vars($this) as $field => $value)
		{
			if ($field == RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS_PRIMARY_KEY)
			{
				continue;
			}

			if (isset($this->{$field}) and $this->{$field} !== null)
			{
				$q->update($field, $this->{$field});
			}
		}

		$q->where(RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS_PRIMARY_KEY, $this->id);
		$q->query();

		return $q->affected();
	}

	public function delete()
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS);
		$q->where(RUDE_DATABASE_TABLE_USER_PLAYLIST_ITEMS_PRIMARY_KEY, $this->id);
		$q->query();

		return $q->affected();
	}
}