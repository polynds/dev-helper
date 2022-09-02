<?php

declare(strict_types=1);
/**
 * happy coding!!!
 */
namespace DevHelper\Lib\UMLParser\Builder;

class UMLTheme
{
    public const NONE = 'none';

    public const AMIGA = 'amiga';

    public const AWS_ORANGE = 'aws-orange';

    public const BLACK_KNIGHT = 'black-knight';

    public const BLEGRAY = 'blegray';

    public const BHEPRINT = 'bheprint';

    public const CARBON_GRAY = 'carbon-gray';

    public const CERULEAN = 'cerulean';

    public const CERULEAN_OUTLINE = 'cerulean-outline';

    public const CRT_AMBER = 'crt-amber';

    public const CRT_GREEN = 'crt-green';

    public const CYBORG = 'cyborg';

    public const CYBORG_OUTLINE = 'cyborg-outline';

    public const HACKER = 'hacker';

    public const LIGHTGRAY = 'lightgray';

    public const MARS = 'mars';

    public const MATERIA = 'materia';

    public const MATERIA_OUTLINE = 'materia-outline';

    public const METAL = 'metal';

    public const MIMEOGRAPH = 'mimeograph';

    public const MINTY = 'minty';

    public const PLAIN = 'plain';

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

    public function getValue(): string
    {
        return $this->value;
    }
}
