<?php

/**
 * Модель дополнительной информации для волонтеров
 *
 * Атрибуты
 * @property integer $id
 * @property integer $id_group
 * @property string $utility
 * @property integer $activity
 * @property integer $id_city
 *
 * Связи
 * @property VolunteerGroup $group
 * @property City $city
 * @property User $user
 */
class Volunteer extends CActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return 'db_volunteer';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('id_group, id_city', 'required'),
            array('id_group, activity, id_city', 'numerical', 'integerOnly' => true),
            array('utility', 'length', 'max' => 200),
            array('id, id_group, utility, activity, id_city', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'group' => array(self::BELONGS_TO, VolunteerGroup::class, array('id_group' => 'id')),
            'city' => array(self::BELONGS_TO, City::class, array('id_city' => 'id')),
            'user' => array(self::BELONGS_TO, User::class, 'id'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'id_group' => 'Группа',
            'utility' => 'Другое',
            'activity' => 'Деятельность',
            'id_city' => 'Город',
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = array('group');
        $criteria->compare('id', $this->id);
        $criteria->compare('id_group', $this->id_group);
        $criteria->compare('utility', $this->utility, true);
        $criteria->compare('activity', $this->activity);
        $criteria->compare('id_city', $this->id_city);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return Volunteer
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}