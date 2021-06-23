<?php

namespace App\Controller;

use App\DTO\DTOInterface;
use App\Exception\DataValidationException;
use App\Transformer\ErrorDTOTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\LogicException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private ErrorDTOTransformer $errorDTOTransformer;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        ErrorDTOTransformer $errorDTOTransformer
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->errorDTOTransformer = $errorDTOTransformer;
    }

    protected function requestBodyConverter(
        string $content,
        string $dto,
        array $deserializeContext = [
            'disable_type_enforcement' => true
        ],
        $validationGroup = null
    ): DTOInterface {
        $requestDTO = $this->serializer->deserialize($content, $dto, 'json', $deserializeContext);
        if (!is_object($requestDTO)) {
            throw new LogicException('RequestDTO must be an object');
        }

        $this->validateInputDTO($requestDTO, $validationGroup);

        return $requestDTO;
    }

    /**
     * @param object $requestDTO
     * @param string|GroupSequence|(string|GroupSequence)[]|null $validationGroup
     *
     * @throws DataValidationException
     */
    protected function validateInputDTO(object $requestDTO, $validationGroup = null): void
    {
        $errors = $this->validator->validate($requestDTO, null, $validationGroup);

        if ($errors->count() > 0) {
            $this->throwInputDTOValidationException($errors);
        }
    }

    /**d
     * @param ConstraintViolationListInterface<ConstraintViolationInterface> $errors
     *
     * @throws DataValidationException
     */
    protected function throwInputDTOValidationException(ConstraintViolationListInterface $errors): void
    {
        throw new DataValidationException(
            ErrorDTOTransformer::MSG_VALIDATION_ERROR,
            $this->errorDTOTransformer->getErrorDTOs($errors),
            Response::HTTP_BAD_REQUEST
        );
    }
}
