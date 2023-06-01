<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */

namespace DevHelper\Lib\UMLParser\Builder;

class UMLTheme
{
    /**
     * 默认主题.
     */
    public const NONE = '_none_';

    /**
     * 阿米加.
     */
    public const AMIGA = 'amiga';

    /**
     * aws-橙色.
     */
    public const AWS_ORANGE = 'aws-orange';

    /**
     * 黑色骑士.
     */
    public const BLACK_KNIGHT = 'black-knight';

    /**
     * 蓝灰色.
     */
    public const BLUEGRAY = 'bluegray';

    /**
     * 蓝图.
     */
    public const BLUEPRINT = 'blueprint';

    /**
     * 碳灰色.
     */
    public const CARBON_GRAY = 'carbon-gray';

    /**
     * 蔚蓝色.
     */
    public const CERULEAN = 'cerulean';

    /**
     * 蔚蓝轮廓.
     */
    public const CERULEAN_OUTLINE = 'cerulean-outline';

    /**
     * crt-琥珀色.
     */
    public const CRT_AMBER = 'crt-amber';

    /**
     * crt-绿色.
     */
    public const CRT_GREEN = 'crt-green';

    /**
     * 半械人.
     */
    public const CYBORG = 'cyborg';

    /**
     * 半械人轮廓.
     */
    public const CYBORG_OUTLINE = 'cyborg-outline';

    /**
     * 黑客.
     */
    public const HACKER = 'hacker';

    /**
     * 浅灰.
     */
    public const LIGHTGRAY = 'lightgray';

    /**
     * 火星
     */
    public const MARS = 'mars';

    /**
     * 材质.
     */
    public const MATERIA = 'materia';

    /**
     * 材质轮廓.
     */
    public const MATERIA_OUTLINE = 'materia-outline';

    /**
     * 金属
     */
    public const METAL = 'metal';

    /**
     * 油印机
     */
    public const MIMEOGRAPH = 'mimeograph';

    /**
     * 薄荷糖
     */
    public const MINTY = 'minty';

    /**
     * 平原
     */
    public const PLAIN = 'plain';

    /**
     * 红色连衣裙-深蓝色
     */
    public const REDDRESS_DARKBLUE = 'reddress-darkblue';

    public const REDDRESS_DARKGREEN = 'reddress-darkgreen';

    public const REDDRESS_DARKORANGE = 'reddress-darkorange';

    public const REDDRESS_DARKRED = 'reddress-darkred';

    public const REDDRESS_LIGHTBLUE = 'reddress-lightblue';

    public const REDDRESS_LGHTGREEN = 'reddress-lghtgreen';

    public const REDDRESS_LIGHTORANGE = 'reddress-lightorange';

    public const REDDRESS_LIGHTRED = 'reddress-lightred';

    public const SANDSTONE = 'sandstone';

    public const SILVER = 'silver';

    public const SKETCHY = 'sketchy';

    public const SKETCHY_OUTLINE = 'sketchy-outline';

    public const SPACELAB = 'spacelab';

    public const SPACELAB_WHITE = 'spacelab-white';

    public const SUPERHERO = 'superhero';

    public const SUPERHERO_OUTLINE = 'superhero-outline';

    public const TOY = 'toy';

    public const UNITED = 'united';

    public const VIBRANT = 'vibrant';

    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function with(string $theme): UMLTheme
    {
        return new static($theme);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
