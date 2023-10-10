import React from 'react';
import {
    Checkbox,
    Table,
    TableCell,
    TableRow
} from '@mui/material';
import StopIcon from '@mui/icons-material/Stop';
import { COLORS } from '../../layouts/Styles';

const Legend = (props) => {
    const numberWithComma = new Intl.NumberFormat();
    return (
        <Table size="small" sx={{ tableLayout: 'fixed' }}>
            {props.items.map((items, index) => (
                <TableRow key={index} role="checkbox" sx={{ whiteSpace: 'nowrap' }}>
                    <TableCell padding="checkbox" style={{paddingLeft: 0, paddingRight: 0}}>
                        <Checkbox
                            disabled
                            size="small"
                            icon={
                                <StopIcon style={{ color: COLORS[index % COLORS.length] }} />
                            }
                        />
                    </TableCell>
                    <TableCell component="th" scope="row" padding="none">
                        {items.name}
                    </TableCell>
                    <TableCell component="td" scope="row" padding="none" align="right">
                        ¥{numberWithComma.format(items.value)}
                    </TableCell>
                </TableRow>
            ))}
        </Table>
    );
}
export default Legend;
