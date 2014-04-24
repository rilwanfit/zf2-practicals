<?php

namespace MHRUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Locale
 *
 * @ORM\Table(name="locale")
 * @ORM\Entity
 */
class Locale
{
    /**
     * @var string
     *
     * @ORM\Column(name="locale_id", type="string", length=5, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $localeId;

    /**
     * @var string
     *
     * @ORM\Column(name="locale_plural_forms", type="string", length=255, nullable=true)
     */
    private $localePluralForms;


}
