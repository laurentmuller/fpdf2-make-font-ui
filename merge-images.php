<?php

/**
 * Merge two images with 30-degree skew using Imagick
 * First image on left, second image on right, both skewed at 30 degrees
 */

try {
    // Load the image
    $inputImage = 'public/images/theme-light.png';
    $outputImage = 'public/images/merged-skewed.png';
    
    if (!file_exists($inputImage)) {
        throw new Exception("Input image not found: $inputImage");
    }
    
    // Create Imagick instances
    $leftImage = new Imagick($inputImage);
    $rightImage = new Imagick($inputImage);
    
    // Set virtual pixel for transparent areas
    $leftImage->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_WHITE);
    $rightImage->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_WHITE);
    
    // Get image dimensions
    $width = $leftImage->getImageWidth();
    $height = $leftImage->getImageHeight();
    
    // Apply perspective distortion (30-degree skew) to left image
    $leftCoordinates = [
        0, 0, 0, 0,                           // top-left (no change)
        $width, 0, $width/2, 0,               // top-right (skew inward)
        0, $height, $width*0.3, $height,      // bottom-left (skew right)
        $width, $height, $width*1.3, $height  // bottom-right (skew outward)
    ];
    $leftImage->distortImage(Imagick::DISTORTION_PERSPECTIVE, $leftCoordinates, false);
    
    // Apply perspective distortion (30-degree skew) to right image
    $rightCoordinates = [
        0, 0, $width/2, 0,                    // top-left (skew inward)
        $width, 0, $width, 0,                 // top-right (no change)
        0, $height, $width*0.3, $height,      // bottom-left (skew right)
        $width, $height, $width*0.8, $height  // bottom-right (skew left)
    ];
    $rightImage->distortImage(Imagick::DISTORTION_PERSPECTIVE, $rightCoordinates, false);
    
    // Create a new image to hold both images side by side
    $canvas = new Imagick();
    $canvas->newImage(
        $leftImage->getImageWidth() + $rightImage->getImageWidth(),
        max($leftImage->getImageHeight(), $rightImage->getImageHeight()),
        new ImagickPixel('white')
    );
    $canvas->setImageFormat('png');
    
    // Composite the left image
    $canvas->compositeImage($leftImage, Imagick::COMPOSITE_DEFAULT, 0, 0);
    
    // Composite the right image
    $canvas->compositeImage($rightImage, Imagick::COMPOSITE_DEFAULT, $leftImage->getImageWidth(), 0);
    
    // Save the result
    $canvas->writeImage($outputImage);
    
    echo "✓ Successfully merged images with 30-degree skew\n";
    echo "Output file: $outputImage\n";
    echo "Dimensions: " . $canvas->getImageWidth() . "x" . $canvas->getImageHeight() . "\n";
    
    // Cleanup
    $leftImage->destroy();
    $rightImage->destroy();
    $canvas->destroy();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

?>
