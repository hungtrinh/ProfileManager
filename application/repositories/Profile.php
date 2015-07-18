<?php

/**
 * @inherit
 * {@inherit}
 * {@inheritdoc}
 */
class Application_Repository_Profile implements Application_Repository_ProfileInterface
{
    /**
     *
     * @var Application_Model_Mapper_ProfileInterface
     */
    private $profileMapper;

    public function __construct(Application_Model_Mapper_ProfileInterface $profileMapper)
    {
        $this->profileMapper = $profileMapper;
    }

    /**
     * @inherit
     * {@inherit}
     * {@inheritdoc}
     */
    public function paginator($page = 1, $size = 25)
    {
        return $this->profileMapper->paginator($page, $size);
    }

    /**
     * Persit profile model to persitent layer
     *
     * @param Application_Model_ProfileInterface $profile
     */
    public function save(Application_Model_ProfileInterface $profile)
    {
        $this->profileMapper->save($profile);
    }

    /**
     * Find profile by profile id
     *
     * @param int $profileId profile id
     * @throw Application_Repository_Exception
     */
    public function findById($profileId)
    {
        $profile = $this->profileMapper->findById($profileId);
        if ($profile) {
            return $profile;
        }
        throw new Application_Repository_Exception('Not found profile', 404);
    }

    /**
     * Find profile by profile id
     *
     * @param int | Application_Model_ProfileInterface $profile profile id or profile entity
     * @throws InvalidArgumentException when inject alpha params
     */
    public function delete($profile)
    {
        if (!is_numeric($profile) && !$profile instanceof Application_Model_ProfileInterface) {
            throw new InvalidArgumentException('Profile id or Application_Model_ProfileInterface instance required');
        }
        $this->profileMapper->deleteProfile($profile);
    }
}
