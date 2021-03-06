<?php
/**
 * Schema learning
 *
 * This file is part of SchemaLearner.
 *
 * SchemaLearner is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 of the License.
 *
 * SchemaLearner is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with SchemaLearner; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package Core
 * @version $Revision: 1236 $
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPL
 */

/**
 * Regular expression optimizer.
 *
 * @package Core
 * @version $Revision: 1236 $
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPL
 */
class slRegularExpressionEmptyOptimizer extends slRegularExpressionOptimizerBase
{
    /**
     * Optimize regular expression
     *
     * Tries to optimize the given regular expression. Returns true if the AST 
     * has been modified, and false otherwise.
     * 
     * @param slRegularExpression $regularExpression 
     * @return bool
     */
    public function optimize( slRegularExpression &$regularExpression )
    {
        // Check if this is only an empty sequence
        if ( ( $regularExpression instanceof slRegularExpressionContainer ) &&
             ( count( $regularExpression ) === 0 ) )
        {
            $regularExpression = new slRegularExpressionEmpty();
            return true;
        }

        // Check if this sequence only contains of empty elements
        if ( $regularExpression instanceof slRegularExpressionContainer )
        {
            do {
                foreach ( $regularExpression->getChildren() as $child )
                {
                    if ( !$child instanceof slRegularExpressionEmpty )
                    {
                        break 2;
                    }
                }

                $regularExpression = new slRegularExpressionEmpty();
                return true;
            } while ( false );
        }

        return $this->recurse( $regularExpression );
    }
}

