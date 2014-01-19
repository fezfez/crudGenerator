<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */
namespace CrudGenerator\Generators\Parser;


class ParserCollection
{
	/**
	 * @var ArrayObject
	 */
	private $preParser = null;
	/**
	 * @var ArrayObject
	 */
	private $postParser = null;

	public function __construct()
	{
		$this->preParser = new \ArrayObject();
		$this->postParser = new \ArrayObject();
	}

	/**
	 * @param ParserInterface $value
	 * @return \CrudGenerator\Generators\Parser\ParserCollection
	 */
	public function addPreParse(ParserInterface $value)
	{
		$this->preParser->append($value);
		return $this;
	}

	/**
	 * @param ParserInterface $value
	 * @return \CrudGenerator\Generators\Parser\ParserCollection
	 */
	public function addPostParse(ParserInterface $value)
	{
		$this->postParser->append($value);
		return $this;
	}

	/**
	 * @return ArrayObject
	 */
	public function getPreParse()
	{
		return $this->preParser;
	}

	/**
	 * @return ArrayObject
	 */
	public function getPostParse()
	{
		return $this->postParser;
	}
}
