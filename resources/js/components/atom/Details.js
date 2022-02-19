import React from 'react';
import Link from '@material-ui/core/Link';
import { withStyles, makeStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Title from './Title';

function preventDefault(event) {
  event.preventDefault();
}
const StyledTableCell = withStyles((theme) => ({
  head: {
    color: theme.palette.common.black,
  },
}))(TableCell);
const useStyles = makeStyles((theme) => ({
  seeMore: {
    marginTop: theme.spacing(3),
  },
  text: {
    align: "right",
  }
}));

export default function Details(props) {
  const classes = useStyles();

  return (
    <React.Fragment>
      <Title>Sales Details</Title>
      <Table size="small">
        <TableHead>
          <TableRow>
            <StyledTableCell>Store</StyledTableCell>
            <StyledTableCell className={classes.text}>product</StyledTableCell>
            <StyledTableCell className={classes.text}>price</StyledTableCell>
            <StyledTableCell className={classes.text}>quantity</StyledTableCell>
            <StyledTableCell className={classes.text}>Store Sum</StyledTableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {props.value.map((detail) => (
            <TableRow key={detail.id}>
              <StyledTableCell>{detail.store}</StyledTableCell>
              <StyledTableCell className={classes.text}>{detail.product}</StyledTableCell>
              <StyledTableCell className={classes.text}>{detail.price}</StyledTableCell>
              <StyledTableCell className={classes.text}>{detail.quantity}</StyledTableCell>
              <StyledTableCell className={classes.text}>{detail.store_sum}</StyledTableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
      {/*
      <div className={classes.seeMore}>
        <Link color="primary" href="#" onClick={preventDefault}>
          See more orders
        </Link>
      </div>
      */}
    </React.Fragment>
  );
}