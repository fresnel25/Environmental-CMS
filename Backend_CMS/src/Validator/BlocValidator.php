<?php

namespace App\Validator;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Enum\BlocType;
use App\Entity\Bloc;

class BlocValidator
{
    public static function validate(Bloc $bloc): void
    {
        $type = $bloc->getTypeBloc();
        $content = $bloc->getContenuJson();

        // TEXTE
        if ($type === BlocType::TEXTE) {
            if (empty($content['text'])) {
                throw new BadRequestHttpException('Text required');
            }
        }

        // MEDIA
        if ($type === BlocType::MEDIA) {
            if (!$bloc->getMedia()) {
                throw new BadRequestHttpException('Media required');
            }
        }

        // VISUALISATION
        if ($type === BlocType::VISUALISATION) {
            if (!$bloc->getVisualisation()) {
                throw new BadRequestHttpException('Visualisation required');
            }
        }
    }
}
