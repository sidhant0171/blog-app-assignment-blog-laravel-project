 <?php


abstract class Shape {
    
    abstract public function area(): float; 
}


class Circle extends Shape {
    private float $radius;

    public function __construct(float $radius) {
        $this->radius = $radius;
    }

    
    public function area(): float {
        return M_PI * $this->radius * $this->radius;
    }
}


class Rectangle extends Shape {
    private float $width;
    private float $height;

    public function __construct(float $width, float $height) {
        $this->width = $width;
        $this->height = $height;
    }

    
    public function area(): float {
        return $this->width * $this->height;
    }
}


$circle = new Circle(5);
$rectangle = new Rectangle(4, 6);

echo "Circle Area (Radius 5): " . $circle->area() . "\n";
echo "Rectangle Area (4x6): " . $rectangle->area() . "\n";
?>