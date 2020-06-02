import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { IYesNoDialogData } from './IYesNoDialogData';

@Component({
  selector: 'app-yes-no-dialog',
  templateUrl: './yes-no-dialog.component.html',
  styleUrls: ['./yes-no-dialog.component.scss']
})
export class YesNoDialogComponent implements OnInit {

  constructor(
    public dialogRef: MatDialogRef<YesNoDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: IYesNoDialogData
  ) { }

  ngOnInit(): void {
  }

  cerraDialogo():void{
    this.dialogRef.close(false);
  }

  confirmado():void{
    this.dialogRef.close(true);
  }

}
