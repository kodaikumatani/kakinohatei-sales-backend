import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Link from '@material-ui/core/Link';
import { makeStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Title from './Title';

function preventDefault(event) {
  event.preventDefault();
}

const useStyles = makeStyles((theme) => ({
  seeMore: {
    marginTop: theme.spacing(3),
  },
  numeric: {
    textAlign: 'right',
  }
}));

export default function Orders() {
  const classes = useStyles();
  const [details, setDetails] = useState([]);
  useEffect(() => {
    getDetails()
  },[])
  const getDetails = async () => {
    const response = await axios.get('/api/sales');
    setDetails(response.data.details)
  }

  return (
    <React.Fragment>
      <Title>Sales Details</Title>
      <Table size="small">
        <TableHead>
          <TableRow>
            <TableCell>Store</TableCell>
            <TableCell>product</TableCell>
            <TableCell className={classes.numeric}>price</TableCell>
            <TableCell className={classes.numeric}>quantity</TableCell>
            <TableCell className={classes.numeric}>Store Sum</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {details.map((detail) => (
            <TableRow key={detail.id}>
              <TableCell>{detail.store}</TableCell>
              <TableCell>{detail.product}</TableCell>
              <TableCell className={classes.numeric}>{detail.price}</TableCell>
              <TableCell className={classes.numeric}>{detail.quantity}</TableCell>
              <TableCell className={classes.numeric}>{detail.store_sum}</TableCell>
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