<?php

/**
 * @package   yii2-postal-code-validator
 * @author    Jonathan Berall <jberall@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @version   1.8.7
 */

namespace jberall\postalcodevalidator;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * TranslationTrait manages methods for all translations
 * <br>based on Krajee extensions author Kartik Visweswaran <kartikv2@gmail.com>
 *
 * @property array $i18n
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.8.7
 */
trait TranslationTrait
{
    /**
     * Yii i18n messages configuration for generating translations
     *
     * @param string $cat the message category
     * @param string $dir the directory path where translation files will exist
     * @param string $basePath defaults to __NAMESPACE__
     *
     * @return void
     */
    public function initI18N($cat,$dir = '', $basePath = __NAMESPACE__)
    {
        if (empty($cat)) {
            return;
        }

        if (empty($dir)) {
            $reflector = new \ReflectionClass(get_class($this));
            $dir = dirname($reflector->getFileName());
        }

        Yii::setAlias("@{$basePath}", $dir);
        $config = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => "@{$basePath}/messages",
            'forceTranslation' => true
        ];
        
        
        $globalConfig = ArrayHelper::getValue(Yii::$app->i18n->translations, $cat, []);
        if (!empty($globalConfig)) {
            $config = array_merge($config, is_array($globalConfig) ? $globalConfig : (array) $globalConfig);
        }
        if (!empty($this->i18n) && is_array($this->i18n)) {
            $config = array_merge($config, $this->i18n);
        }
        Yii::$app->i18n->translations[$cat] = $config;
        
        return true;
    }
}
