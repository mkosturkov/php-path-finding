<?php

use \KISS\PathFinding\{
    Vertex,
    Exceptions\NoDistanceFromStartSetException,
    Implementations\InRAM\InRAMVertex
};

/**
 * Description of InRAMVertexTest
 *
 * @author Milko Kosturkov<mkosturkov@gmail.com>
 */
class InRAMVertexTest extends PHPUnit_Framework_TestCase
{
    private $vertexId = 'vid';
    
    private $vertex;
    
    public function setUp()
    {
        parent::setUp();
        $this->vertex = new InRAMVertex($this->vertexId);
    }
    
    public function testDefaultValues()
    {
        $this->assertEquals($this->vertexId, $this->vertex->getId(), 'Unmatching vertex id');
        $this->assertFalse($this->vertex->hasDistanceFromStartSet(), 'Vertex says it has distance when none set');
        $this->assertFalse($this->vertex->isWalked(), 'Vertex says it is walked when it hasn\'t been' );
    }
    
    public function testDistanceFromStartException()
    {
        $this->expectException(NoDistanceFromStartSetException::class);
        $this->vertex->getDistanceFromStart();
    }
    
    public function testVertexToStartException()
    {
        $this->expectException(NoDistanceFromStartSetException::class);
        $this->vertex->getVertexToStart();
    }
    
    public function testSettingDistanceToStartThroughVertex()
    {
        $throughVertex = $this->getMockForAbstractClass(Vertex::class);
        $testId = 'asd';
        $throughVertex->method('getId')->willReturn($testId);
        $testDistance = 8;
        $this->vertex->setDistanceFromStartThroughVertex($testDistance, $throughVertex);
        $this->assertTrue(
            $this->vertex->hasDistanceFromStartSet(),
            'Vertex says no distance has been set when it has been'
        );  
        $this->assertEquals($testId, $this->vertex->getVertexToStart()->getId(), 'Vertex to start returned wrong id');
        $this->assertEquals($testDistance, $this->vertex->getDistanceFromStart(), 'Wrong distance from start');
    }
    
    public function testMarkingAsWalked()
    {
        $this->vertex->markAsWalked();
        $this->assertTrue($this->vertex->isWalked(), 'Vertex says it has not been walked when it has been');
    }
    
}