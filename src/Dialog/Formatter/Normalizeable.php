<?php

/**
 * This file is part of the Dialog package.
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 *
 * @copyright (c) Henning Huncke - <mordilion@gmx.de>
 */

namespace Dialog\Formatter;

use Dialog\Record\RecordInterface;

/**
 * Dialog Normalizeable-Trait.
 *
 * @author Henning Huncke <mordilion@gmx.de>
 */
trait Normalizeable
{
    /**
     * Format of normalized datetime information.
     *
     * @var string
     */
    private $datetimeFormat = \DateTime::ATOM;


    /**
     * Returns the normalized date format.
     *
     * @return string
     */
    public function getDatetimeFormat()
    {
        return $this->datetimeFormat;
    }

    /**
     * Normalizes the provided $data based on what type the provided $data is.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function normalize($data)
    {
        if ($data instanceof RecordInterface) {
            return $this->normalizeRecord($data);
        }

        if ($data === null || is_scalar($data)) {
            return $data;
        }

        if (is_object($data)) {
            return $this->normalizeObject($data);
        }

        if (is_array($data)) {
            return $this->normalizeArray($data);
        }

        if (is_resource($data)) {
            return sprintf('[resource::%s]', get_resource_type($data));
        }

        return sprintf('[unknown::%s]', gettype($data));
    }

    /**
     * Normalizes all the values of the provided $array and returns a normalized array.
     *
     * @param array $array
     *
     * @return array
     */
    public function normalizeArray(array $array, $jsonEncode = false)
    {
        $result = array();

        if ($jsonEncode) {
            $result = @json_encode($array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            foreach ($array as $key => $value) {
                $result[$key] = $this->normalize($value);
            }
        }

        return $result;
    }

    /**
     * Normalizes the provided $datetime into a string with the provided $format.
     *
     * @param \DateTimeInterface $datetime
     * @param string $format
     *
     * @return string
     */
    public function normalizeDatetime(\DateTimeInterface $datetime, $format)
    {
        return $datetime->format($format);
    }

    /**
     * Normalizes the provided $exception into an array.
     *
     * @param \Throwable $exception
     *
     * @return array
     */
    public function normalizeException(\Throwable $exception)
    {
        $result = array(
            'class'   => get_class($exception),
            'code'    => $exception->getCode(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
            'message' => $exception->getMessage()
        );

        $result['trace'][] = $exception->getTrace();

        if ($previous = $exception->getPrevious()) {
            $result['previous'] = $this->normalizeException($previous);
        }

        return $result;
    }

    /**
     * Normalizes the provided $obejct into different things. It based on the type of object.
     *
     * @param object $object
     *
     * @return mixed
     */
    public function normalizeObject($object)
    {
        if (is_object($object)) {
            if ($object instanceof \Throwable) {
                return $this->normalizeException($object);
            }

            if ($object instanceof \DateTimeInterface) {
                return $this->normalizeDatetime($object, $this->getDatetimeFormat());
            }

            if ($object instanceof \JsonSerializable) {
                $value = $object->jsonSerialize();
            } elseif (method_exists($object, '__toString')) {
                $value = $object->__toString();
            } elseif (method_exists($object, 'toArray')) {
                $value = $object->toArray();
            } else {
                $encoded = @json_encode($object, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);

                if ($encoded === false) {
                    $value = 'JSON_ERROR';
                } else {
                    $value = json_decode($encoded, true);
                }
            }

            return array(get_class($object) => $this->normalize($value));
        }

        return false;
    }

    /**
     * Normalizes the provided $record into a normalized array.
     *
     * @param RecordInterface $record
     *
     * @return array
     */
    public function normalizeRecord(RecordInterface $record)
    {
        $configuration = $record->getConfiguration();
        $array = $configuration->toArray();

        unset($array['formatted']);

        return $this->normalizeArray($array);
    }

    /**
     * Sets the normalized date format.
     *
     * @return string
     */
    public function setDatetimeFormat($format)
    {
        $this->datetimeFormat = (string)$format;

        return $this;
    }
}