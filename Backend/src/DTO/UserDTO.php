<?php

namespace App\DTO;

readonly class UserDTO {
	public int $id;

	public string $pseudo;

	public int $avancement;

	public int $score;

	public int $waifu;

	public function __construct(
		int $id,
		string $pseudo,
		int $avancement,
		int $score,
		int $waifu
	){
		$this->id = $id;
		$this->pseudo = $pseudo;
		$this->avancement = $avancement;
		$this->score = $score;
		$this->waifu = $waifu;
	}
}
