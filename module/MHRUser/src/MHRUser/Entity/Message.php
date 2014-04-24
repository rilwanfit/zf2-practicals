<?php

namespace MHRUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="locale_id", columns={"locale_id"}), @ORM\Index(name="message_domain", columns={"message_domain"})})
 * @ORM\Entity
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="message_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $messageId;

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

    /**
     * @var boolean
     *
     * @ORM\Column(name="message_plural_index", type="boolean", nullable=false)
     */
    private $messagePluralIndex;

    /**
     * @var \MHRUser\Entity\Locale
     *
     * @ORM\ManyToOne(targetEntity="MHRUser\Entity\Locale")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="locale_id", referencedColumnName="locale_id")
     * })
     */
    private $locale;


}
