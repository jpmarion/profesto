import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { IOkDialogData } from './IOkDialogData';

@Component({
  selector: 'app-ok-dialog',
  templateUrl: './ok-dialog.component.html',
  styleUrls: ['./ok-dialog.component.scss']
})
export class OkDialogComponent implements OnInit {

  constructor(
    public dialogRef: MatDialogRef<OkDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: IOkDialogData
  ) { }

  ngOnInit(): void {
  }

  ok() {
    this.dialogRef.close();
  }
}
