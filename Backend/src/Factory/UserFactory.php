<?php

namespace App\Factory;

use App\DTO\UserDTO;
use App\Entity\User;

class UserFactory {
	public function toDTO(User $user): UserDTO{
		return new UserDTO(
			id: $user->getId(),
			pseudo: $user->getPseudo()
		);
	}
}
