<?php

namespace Application\Resource\Artist;

/**
 * Class ArtistMapperGetterTrait
 * @package Application\Resource\Artist
 */
trait ArtistMapperGetterTrait {

	/**
	 * Get artist mapper.
	 *
	 * @return ArtistMapper
	 */
	public function getArtistMapper() {
		return $this->getServiceLocator()->get('Application\\Resource\\Artist\\ArtistMapper');
	}
} 