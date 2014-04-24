<?php

namespace MHRUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Translation
 *
 * @ORM\Table(name="translation", indexes={@ORM\Index(name="message_domain", columns={"message_domain"})})
 * @ORM\Entity
 */
class Translation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=5, nullable=false)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="message_domain", type="string", length=255, nullable=false)
     */
    private $messageDomain;

    /**
     * @var string
     *
     * @ORM\Column(name="message_key", type="text", nullable=false)
     */
    private $messageKey;

    /**
     * @var string
     *
     * @ORM\Column(name="message_translation", type="text", nullable=false)
     */
    private $messageTranslation;


}
