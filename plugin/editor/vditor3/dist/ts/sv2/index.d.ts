/// <reference types="./types" />
declare class Editor2 {
    element: HTMLPreElement;
    composingLock: boolean;
    preventInput: boolean;
    processTimeoutId: number;
    hlToolbarTimeoutId: number;
    range: Range;
    constructor(vditor: IVditor);
    private bindEvent;
}
export { Editor2 };
