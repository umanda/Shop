<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Components\Customer\Models;

trait Presenters
{
    /**
     * Returns the user full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $firstName = ($this->isPerson() || $this->isAdmin()) ? 'first_name' : 'business_name';

        return ucwords($this->profile->$firstName . ' ' . $this->profile->last_name);
    }

    /**
     * Checks whether the user has a phone number.
     *
     * @return bool
     */
    public function getHasPhoneAttribute()
    {
        return ! is_null($this->mobile_phone) || ! is_null($this->work_phone) || ($this->profile() && $this->profile()->has_phone);
    }

    /**
     * Sets the password attribute.
     *
     * @param string $value
     */
    public function setPasswordAttribute($value)
    {
        if (isset($value)) {
            $this->attributes['password'] = $value;
        }
    }
}