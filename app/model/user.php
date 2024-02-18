<?php

namespace model;

use DateTime;

class User
{
    public int $UserID;
    public string $Username;
    public string $Email;
    public string $Password;
    public ?string $ProfilePicture;
    public ?string $Bio;
    public string $role;

    public function __construct()
    {
    }

    public function getUserID(): int
    {
        return $this->UserID;
    }

    public function getUsername(): string
    {
        return $this->Username;
    }

    public function getEmail(): string
    {
        return $this->Email;
    }

    public function getPassword(): string
    {
        return $this->Password;
    }

    public function getProfilePicture(): ?string
    {
        return $this->ProfilePicture;
    }

    public function getBio(): ?string
    {
        return $this->Bio;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setUserID(int $UserID): void
    {
        $this->UserID = $UserID;
    }

    public function setUsername(string $Username): void
    {
        $this->Username = $Username;
    }

    public function setEmail(string $Email): void
    {
        $this->Email = $Email;
    }

    public function setPassword(string $Password): void
    {
        $this->Password = $Password;
    }

    public function setProfilePicture(?string $ProfilePicture): void
    {
        $this->ProfilePicture = $ProfilePicture;
    }

    public function setBio(?string $Bio): void
    {
        $this->Bio = $Bio;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }


}