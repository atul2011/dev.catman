<?php
namespace Models;

use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithCustomCollectionName;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkModelWithDefaultExtract;
use Quark\IQuarkNullableModel;
use Quark\IQuarkStrongModel;
use Quark\Quark;
use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkModel;

/**
 * Class Event
 *
 * @property int $id
 * @property string $name
 * @property QuarkDate $startdate
 *
 * @package Models
 */
class Event implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider, IQuarkModelWithDefaultExtract, IQuarkModelWithCustomCollectionName, IQuarkLinkedModel, IQuarkNullableModel {
	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			'id' => 0,
			'name' => '',
			'startdate' =>QuarkDate::GMT
		);
	}

	/**
	 * @return string
	 */
	public function CollectionName () {
		return 'events';
	}

	/**
	 * @return mixed
	 */
	public function Rules () {
		// TODO: Implement Rules() method.
	}

	/**
	 * @return string
	 */
	public function DataProvider () {
		return CM_DATA;
	}

	/**
	 * @param array $fields
	 * @param bool $weak
	 *
	 * @return array
	 */
	public function DefaultExtract ($fields, $weak) {
		if(!$fields === null) return $fields;

		return array(
			'id',
			'name',
			'startdate'
		);
	}

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new Event(), $raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return (string)$this->id;
	}

	/**
	 * @return QuarkModel|Event
	 */
	public static function DefaultEvent () {
		return QuarkModel::FindOne(new Event());
	}

	/**
	 * @return QuarkCollection|Event[]
	 */
	public static function QuestionEvents () {
		/**
		 * @var QuarkCollection|Article[] $articles
		 * @var QuarkCollection|Event[] $events
		 */
		$articles = QuarkModel::Find(new Article(), array('type' => Article::TYPE_QUESTION));
		$events = new QuarkCollection(new Event());
		$events_ids = array();

		foreach ($articles as $article) {
			if (!in_array($article->event_id->value, $events_ids)) {
				if ($article->event_id->value == '1') continue;

				$events_ids[] = $article->event_id->value;
				$events[] = $article->event_id->Retrieve();
			}
		}

		return $events->Select(array(
			'name' => array('$ne' => '')
		), array(
			QuarkModel::OPTION_SORT => array('startdate' => QuarkModel::SORT_ASC)
		));
	}
}