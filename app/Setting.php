<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Setting
 *
 * @property int $id
 * @property string $site_name
 * @property string $logo
 * @property string $enquiry_receiver
 * @property bool $smtp
 * @property string|null $smtp_crypto
 * @property string|null $smtp_host
 * @property int|null $smtp_port
 * @property string|null $smtp_email
 * @property string|null $smtp_password
 * @property string $default_meta_title
 * @property string|null $default_meta_keywords
 * @property string|null $default_meta_description
 * @property string|null $embed_script_top
 * @property string|null $embed_script_bottom
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereDefaultMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereDefaultMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereDefaultMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereEmbedScriptBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereEmbedScriptTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereEnquiryReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereSiteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereSmtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereSmtpCrypto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereSmtpEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereSmtpHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereSmtpPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereSmtpPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    protected $casts = [
        'smtp' => 'boolean',
        'is_maintenance_mode' => 'boolean',
    ];

    private $itemPerPage = 20;

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'settings';
    }

    /**
     * @return int
     */
    public function getItemPerPage(): int
    {
        return $this->itemPerPage;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSiteName(): string
    {
        return $this->site_name;
    }

    /**
     * @param string $site_name
     */
    public function setSiteName(string $site_name): void
    {
        $this->site_name = $site_name;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return string
     */
    public function getEnquiryReceiver(): string
    {
        return $this->enquiry_receiver;
    }

    /**
     * @param string $enquiry_receiver
     */
    public function setEnquiryReceiver(string $enquiry_receiver): void
    {
        $this->enquiry_receiver = $enquiry_receiver;
    }

    /**
     * @return bool
     */
    public function isSmtp(): bool
    {
        return $this->smtp;
    }

    /**
     * @param bool $smtp
     */
    public function setSmtp(bool $smtp): void
    {
        $this->smtp = $smtp;
    }

    /**
     * @return null|string
     */
    public function getSmtpCrypto(): ?string
    {
        return $this->smtp_crypto;
    }

    /**
     * @param null|string $smtp_crypto
     */
    public function setSmtpCrypto(?string $smtp_crypto): void
    {
        $this->smtp_crypto = $smtp_crypto;
    }

    /**
     * @return null|string
     */
    public function getSmtpHost(): ?string
    {
        return $this->smtp_host;
    }

    /**
     * @param null|string $smtp_host
     */
    public function setSmtpHost(?string $smtp_host): void
    {
        $this->smtp_host = $smtp_host;
    }

    /**
     * @return int|null
     */
    public function getSmtpPort(): ?int
    {
        return $this->smtp_port;
    }

    /**
     * @param int|null $smtp_port
     */
    public function setSmtpPort(?int $smtp_port): void
    {
        $this->smtp_port = $smtp_port;
    }

    /**
     * @return null|string
     */
    public function getSmtpEmail(): ?string
    {
        return $this->smtp_email;
    }

    /**
     * @param null|string $smtp_email
     */
    public function setSmtpEmail(?string $smtp_email): void
    {
        $this->smtp_email = $smtp_email;
    }

    /**
     * @return null|string
     */
    public function getSmtpPassword(): ?string
    {
        return $this->smtp_password;
    }

    /**
     * @param null|string $smtp_password
     */
    public function setSmtpPassword(?string $smtp_password): void
    {
        $this->smtp_password = $smtp_password;
    }

    /**
     * @return string
     */
    public function getDefaultMetaTitle(): string
    {
        return $this->default_meta_title;
    }

    /**
     * @param string $default_meta_title
     */
    public function setDefaultMetaTitle(string $default_meta_title): void
    {
        $this->default_meta_title = $default_meta_title;
    }

    /**
     * @return null|string
     */
    public function getDefaultMetaKeywords(): ?string
    {
        return $this->default_meta_keywords;
    }

    /**
     * @param null|string $default_meta_keywords
     */
    public function setDefaultMetaKeywords(?string $default_meta_keywords): void
    {
        $this->default_meta_keywords = $default_meta_keywords;
    }

    /**
     * @return null|string
     */
    public function getDefaultMetaDescription(): ?string
    {
        return $this->default_meta_description;
    }

    /**
     * @param null|string $default_meta_description
     */
    public function setDefaultMetaDescription(?string $default_meta_description): void
    {
        $this->default_meta_description = $default_meta_description;
    }

    /**
     * @return null|string
     */
    public function getEmbedScriptTop(): ?string
    {
        return $this->embed_script_top;
    }

    /**
     * @param null|string $embed_script_top
     */
    public function setEmbedScriptTop(?string $embed_script_top): void
    {
        $this->embed_script_top = $embed_script_top;
    }

    /**
     * @return null|string
     */
    public function getEmbedScriptBottom(): ?string
    {
        return $this->embed_script_bottom;
    }

    /**
     * @param null|string $embed_script_bottom
     */
    public function setIsMaintenanceMode($is_maintenance_mode): void
    {
        $this->is_maintenance_mode = $is_maintenance_mode;
    }

    /**
     * @return null|string
     */
    public function getIsMaintenanceMode(): ?bool
    {
        return $this->is_maintenance_mode;
    }

    /**
     * @param null|string $embed_script_bottom
     */
    public function setEmbedScriptBottom(?string $embed_script_bottom): void
    {
        $this->embed_script_bottom = $embed_script_bottom;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function getCreatedAt(): ?\Carbon\Carbon
    {
        return $this->created_at;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function getUpdatedAt(): ?\Carbon\Carbon
    {
        return $this->updated_at;
    }
}
